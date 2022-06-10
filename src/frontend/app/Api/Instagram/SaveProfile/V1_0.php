<?php namespace App\Api\Instagram\SaveProfile;

use \App\Libraries\Utils\Output;
use Config\Services;
use Pheanstalk\Pheanstalk;

class V1_0
{
    public function __construct()
    {
        $this->output = new Output();
        $this->db     = \Config\Database::connect();
        $this->cache  = Services::cache();
    }

    /**
     * Код функции
     */
    public function execute($params = [])
    {
        if(!isset($params['unique_id'])
           || !isset($params['username'])
           || !isset($params['biography'])
           || !isset($params['picture'])
           || !isset($params['followers'])
           || !isset($params['following'])
           || !isset($params['verified'])
           || !isset($params['private'])
           || !isset($params['media_count']))
        {
            return $this->output->error(11);
        }

        $data = [
            'unique_id'   => (int) $params['unique_id'],
            'username'    => $params['username'],
            'biography'   => $params['biography'] === '' ?  null : $params['biography'],
            'picture'     => PROXY_WORKER_URL . $params['picture'],
            'followers'   => (int) $params['followers'],
            'following'   => (int) $params['following'],
            'verified'    => $params['verified'] ? 1 : 0,
            'private'     => $params['private']  ? 1 : 0,
            'media_count' => (int) $params['media_count'],
            'date_create' => time(),
            'date_update' => time(),
        ];

        try
        {
            $this->db->table('instagram_profiles')->insert($data);
        } catch (\Exception $e)
        {
            return $this->output->error(13);
        }
        $data['id']      = $this->db->insertID();
        $data['picture'] = $params['picture'];

        $pheanstalk = Pheanstalk::create('beanstalkd');
        $pheanstalk->useTube('profile')->put(json_encode($data));

        $data['picture'] = PROXY_WORKER_URL . $params['picture'];

        return $this->output->collection($data);
    }
}