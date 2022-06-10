<?php namespace App\Api\Instagram\GetPostList;

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
            ->table('instagram_posts')
            ->select('id, unique_id, preview, date_create')
            ->where('profile_id', $params['profile_id'])
            ->get()->getResult();
        if ( ! empty($data)) {
            $response = [];
            foreach ($data as $row) {
                $item = [
                    'unique_id'   => $row->unique_id,
                    'preview'     => $row->preview,
                    'content'     => [],
                    'date_create' => (int)$row->date_create,
                ];

                $item['content'] = $this->db
                    ->table('instagram_posts_content')
                    ->select('unique_id, content, type')
                    ->where('post_id', (int)$row->id)
                    ->get()->getResult();

                $response[] = $item;
            }
            return $this->output->collection($response);
        }

        $profile = $this->db
            ->table('instagram_profiles')
            ->select('id, username')
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
            ))->call('data');

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

        $response = $instagram->response->data->posts;

        foreach ($response as $main_row) {
            $data = [
                'profile_id'  => $profile->id,
                'unique_id'   => $main_row->unique_id,
                'preview'     => $main_row->preview,
                'date_create' => (int)$main_row->date_create,
                'date_expire' => (int)$main_row->date_create + 172800, // 2 дня
            ];
            $this->db->table('instagram_posts')->insert($data);
            $data['id'] = $this->db->insertID();

            $batch = [];
            foreach ($main_row->content as $content_row) {
                $batch[] = [
                    'post_id'   => $data['id'],
                    'unique_id' => $content_row->unique_id,
                    'content'   => $content_row->content,
                    'type'      => $content_row->type,
                ];
            }
            $this->db->table('instagram_posts_content')->insertBatch($batch);
        }

        return $this->output->collection($response);
    }
}
