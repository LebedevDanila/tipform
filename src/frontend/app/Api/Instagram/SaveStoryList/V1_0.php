<?php namespace App\Api\Instagram\SaveStoryList;

use \App\Libraries\Utils\Output;
use Pheanstalk\Pheanstalk;

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
        if(!isset($params['data']) || !isset($params['profile_id']) || !isset($params['profile_username']))
        {
            return $this->output->error(11);
        }

        $resp = [];
        foreach ($params['data'] as $row) {
            $data = [
                'profile_id'  => $params['profile_id'],
                'unique_id'   => $row->unique_id,
                'preview'     => PROXY_WORKER_URL . $row->preview,
                'content'     => PROXY_WORKER_URL . $row->content,
                'date_create' => (int) $row->date_create,
                'date_expire' => (int) $row->date_expire,
                'date_public' => time(),
                'type'        => $row->type,
            ];

            try {
                $this->db->table('instagram_stories')->insert($data);
            } catch (\Exception $e) {
                return $this->output->error(13);
            }
            $data['id']               = $this->db->insertID();
            $data['profile_username'] = $params['profile_username'];
            $data['preview']          = $row->preview;
            $data['content']          = $row->content;

            $pheanstalk = Pheanstalk::create('beanstalkd');
            $pheanstalk->useTube('story')->put(json_encode($data));

            $resp[] = $data;
        }

        return $this->output->collection($resp);
    }
}
