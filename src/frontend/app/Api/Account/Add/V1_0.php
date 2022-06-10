<?php namespace App\Api\Account\Add;

use \App\Libraries\Utils\Output;
use Config\Database;

class V1_0
{
    public function __construct()
    {
        $errors = [];
        $this->output = new Output($errors);
        $this->db     = Database::connect();
    }

    /**
     * Код функции
     */
    public function execute($params = [])
    {
        if(empty($params['login']) || empty($params['password']))
        {
            return $this->output->error(11);
        }

        $data = [
            'login'            => $params['login'],
            'password'         => $params['password'],
            'status'           => '1',
            'date_create'      => time(),
            'date_last_action' => time(),
            'proxy_ip'         => $params['proxy_ip'],
            'proxy_login'      => $params['proxy_login'],
            'proxy_password'   => $params['proxy_password'],
        ];

        try {
            $this->db->table('instagram_accounts')->insert($data);
        } catch(\Exception $e)
        {
            return $this->output->error(13);
        }
        $data['id'] = $this->db->insertID();

        /*$auth = (new Api())->call('instagram.authAccount', [
            'id'       => $data['id'],
            'login'    => $data['login'],
            'password' => $data['password'],
            'proxy'    => $data['proxy'],
            'type'     => 'background',
        ]);
        if(!empty($auth->error))
        {
            return $this->output->error($auth->error->error_code);
        }*/

        return $this->output->collection($data);
    }
}
