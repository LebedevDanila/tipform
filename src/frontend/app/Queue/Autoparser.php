<?php

namespace App\Queue;

use App\Jobs\Instagram\ParserInstanavigation;
use App\Libraries\Api;
use CodeIgniter\Controller;
use Config\Database;
use Config\Sentry;
use Config\Services;
use Pheanstalk\Pheanstalk;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Autoparser extends Controller {

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
        $pheanstalk->watch('autoparser');

        while (true) {
            if (!$job = $pheanstalk->reserveWithTimeout(50)) {
                // если задач пока нет, пропускаем итерацию
                // "засыпаем" на 2 секунды
                sleep(2);
                continue;
            }

            $payload = $job->getData();
            $payload = json_decode($payload, true);

            $candidate = $this->db
                ->table('instagram_profiles')
                ->where('username', $payload['username'])
                ->get()->getRow();
            if (isset($candidate)) {
                $pheanstalk->delete($job);
                sleep(2);
                continue;
            }

            $account = (new Api())->call('account.getByLastAction');
            if (isset($account->error)) {
                $pheanstalk->release($job);
                sleep(2);
                continue;
            }

            $instagram = (new ParserInstanavigation(
                [
                    'username' => $payload['username'],
                    'proxy'    => [
                        'ip'       => $account->proxy_ip,
                        'login'    => $account->proxy_login,
                        'password' => $account->proxy_password,
                    ],
                ]
            ))->call('data');
            if (isset($instagram->error)) {
                sleep(10);
                $pheanstalk->release($job);
                continue;
            }
            $instagram = $instagram->response->data;

            // сообщаем что очередь жива
            $pheanstalk->touch($job);
            sleep(2);

            (new Api())->call(
                'instagram.saveProfile',
                [
                    'unique_id'   => $instagram->unique_id,
                    'username'    => $instagram->username,
                    'biography'   => $instagram->biography,
                    'picture'     => $instagram->picture,
                    'followers'   => $instagram->followers,
                    'following'   => $instagram->following,
                    'verified'    => $instagram->verified ? 1 : 0,
                    'private'     => $instagram->private ? 1 : 0,
                    'media_count' => $instagram->media_count,
                ]
            );

            sleep(5);

            $pheanstalk->delete($job);
        }
    }

}
