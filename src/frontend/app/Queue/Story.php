<?php

namespace App\Queue;

use CodeIgniter\Controller;
use Config\Database;
use Config\Sentry;
use Config\Services;
use Pheanstalk\Pheanstalk;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use \App\Libraries\Utils\Cdn;

class Story extends Controller {

    protected $helpers = [
        'general',
    ];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->sentry = Sentry::init();
    }

    public function run() {
        ini_set('memory_limit', '-1');
        ini_set('upload_max_size' , '999M');
        ini_set('post_max_size', '999M');
        ini_set('max_execution_time', '300');

        $this->db    = Database::connect();
        $this->cache = Services::cache();
        $pheanstalk  = Pheanstalk::create('beanstalkd');
        $pheanstalk->watch('story');

        while (true) {
            if (!$job = $pheanstalk->reserveWithTimeout(50)) {
                // если задач пока нет, пропускаем итерацию
                // "засыпаем" на 2 секунды
                sleep(2);
                continue;
            }

            $payload = $job->getData();
            $payload = json_decode($payload, true);

            $path        = PATH_CDN_INSTAGRAM_PROFILES . $payload['profile_username'] . '/stories/' . $payload['unique_id'];
            $preview_url = $path . '/preview.jpg';
            $content_url = $path . '/content' . ($payload['type'] === 'video' ? '.mp4' : '.jpg');
            (new Cdn())->put($preview_url, $this->url_get_contents($payload['preview']));
            (new Cdn())->put($content_url, $this->url_get_contents($payload['content']));

            $this->db
                ->table('instagram_stories')
                ->where('unique_id', $payload['unique_id'])
                ->set(['preview' => CDN_DOMAIN . $preview_url, 'content' => CDN_DOMAIN . $content_url])
                ->update();

            $pheanstalk->delete($job);
        }
    }

    private function url_get_contents($url) {
        if (function_exists('curl_exec')){
            $conn = curl_init($url);
            curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
            curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
            $url_get_contents_data = (curl_exec($conn));
            curl_close($conn);
        }elseif(function_exists('file_get_contents')){
            $url_get_contents_data = file_get_contents($url);
        }elseif(function_exists('fopen') && function_exists('stream_get_contents')){
            $handle = fopen ($url, "r");
            $url_get_contents_data = stream_get_contents($handle);
        }else{
            $url_get_contents_data = false;
        }
        return $url_get_contents_data;
    }
}