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

class Profile extends Controller {

    protected $helpers = [
        'general',
    ];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->sentry = Sentry::init();
    }

    public function run() {
        $this->db    = Database::connect();
        $this->cache = Services::cache();
        $pheanstalk  = Pheanstalk::create('beanstalkd');
        $pheanstalk->watch('profile');

        while (true) {
            if (!$job = $pheanstalk->reserveWithTimeout(50)) {
                // если задач пока нет, пропускаем итерацию
                // "засыпаем" на 2 секунды
                sleep(2);
                continue;
            }

            $payload = $job->getData();
            $payload = json_decode($payload, true);

            $path        = PATH_CDN_INSTAGRAM_PROFILES . $payload['username'] . '/picture/';
            $picture_url = $path . 'picture.jpg';
            (new Cdn())->put($picture_url, $this->url_get_contents($payload['picture']));

            $this->db
                ->table('instagram_profiles')
                ->where('unique_id', $payload['unique_id'])
                ->set(['picture' => CDN_DOMAIN . $picture_url])
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
