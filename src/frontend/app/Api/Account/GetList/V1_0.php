<?php namespace App\Api\Account\GetList;

use \App\Libraries\Utils\Output;
use Config\Database;

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
        $response = [];
        
        $accounts = $this->db
            ->table('instagram_accounts')
            ->get()->getResult();

        foreach ($accounts as $row) {
            $response[] = [
                'id'               => (int) $row->id,
                'login'            => $row->login,
                'password'         => $row->password,
                'status'           => $row->status,
                'date_create'      => (int) $row->date_create,
                'date_last_action' => (int) $row->date_last_action,
                'proxy_ip'         => $row->proxy_ip,
                'proxy_login'      => $row->proxy_login,
                'proxy_password'   => $row->proxy_password,
            ];
        }

        return $this->output->collection($response);
    }
}

