<?php namespace App\Api\Instagram\DownloadPost;

use App\Jobs\Instagram\ParserMicroservices;
use App\Libraries\Api;
use \App\Libraries\Utils\Output;
use Config\Database;
use App\Jobs\Instagram\Download;

class V1_0
{
    public function __construct()
    {
        $this->output = new Output();
        $this->db     = Database::connect();
    }

    /**
     * Код функции
     */
    public function execute($params = [])
    {
        if ( ! isset($params['url'])) {
            return $this->output->error(11);
        }

        $explode = explode('/', $params['url']);
        if ($explode[2] !== 'www.instagram.com' || $explode[3] !== 'p') {
            return $this->output->error(225);
        }

        $try          = 3;
        $count_errors = 0;
        for ($i = 0; $i < $try; $i++) {
            $account = (new Api())->call('account.getByLastAction');
            if ( ! empty($account->error)) {
                return $this->output->error($account->error->code);
            }

            $response = (new ParserMicroservices(
                [
                    'proxy' => [
                        'ip'       => $account->proxy_ip,
                        'login'    => $account->proxy_login,
                        'password' => $account->proxy_password,
                    ],
                ]
            ))->postAndIgtv($params['url']);
            if (isset($response->error)) {
                $count_errors++;
            } else {
                break;
            }
        }
        if ($count_errors >= $try) {
            return $this->output->error(333);
        }

        return $this->output->collection($response->response->data);
    }
}


