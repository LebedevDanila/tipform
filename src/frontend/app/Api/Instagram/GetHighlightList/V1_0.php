<?php namespace App\Api\Instagram\GetHighlightList;

use App\Libraries\Api;
use App\Jobs\Instagram\ParserInstanavigation;
use \App\Libraries\Utils\Output;

class V1_0
{
    public function __construct()
    {
        $this->output = new Output();
        $this->db     = \Config\Database::connect();
    }

    /**
     * Код функции
     */
    public function execute($params = [])
    {
        if( ! isset($params['profile_id'])) {
            return $this->output->error(11);
        }

        $data = $this->db
            ->table('instagram_highlights')
            ->select('unique_id, title, preview')
            ->where('profile_id', $params['profile_id'])
            ->get()->getResult();
        if ( ! empty($data)) {
            return $this->output->collection($data);
        }

        $profile = $this->db
            ->table('instagram_profiles')
            ->select('id, unique_id, username')
            ->where('id', $params['profile_id'])
            ->get()->getRow();

        $try          = 3;
        $count_errors = 0;
        for ($i = 0; $i < $try; $i++) {
            $account = (new Api())->call('account.getByLastAction');
            if (isset($account->error)) {
                return $this->output->error($account->error->code);
            }

            $instagram = (new ParserInstanavigation(
                [
                    'username' => $profile->username,
                    'proxy'    => [
                        'ip'       => $account->proxy_ip,
                        'login'    => $account->proxy_login,
                        'password' => $account->proxy_password,
                    ],
                ]
            ))->call('highlights', ['profile_unique_id' => $profile->unique_id]);

            if (isset($instagram->error)) {
                if ($instagram->error->code == 380) {
                    return $this->output->error(380);
                }
                if ($instagram->error->code == 385) {
                    return $this->output->error(385);
                }
                $count_errors++;
            } else {
                break;
            }
        }
        if ($count_errors >= $try) {
            return $this->output->error(333);
        }

        $response = $instagram->response->data;

        $batch = [];
        foreach ($response as $row) {
            $batch[] = [
                'profile_id'  => $profile->id,
                'unique_id'   => $row->unique_id,
                'title'       => $row->title,
                'preview'     => $row->preview,
                'date_create' => time(),
                'date_expire' => time() + 172800, // 2 дня
            ];
        }
        $this->db->table('instagram_highlights')->insertBatch($batch);

        return $this->output->collection($response);
    }
}
