<?php namespace App\Api\Account\GetByLastAction;

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
        $builder = $this->db->table('instagram_accounts');

        // выбираем аккаунт который дествовал меньше всех
        $account = $builder
            ->select('*')
            ->where('status', '1')
            ->orderBy('date_last_action', 'ASC')
            ->get()->getRow();

        // обновляем ему время последнего действия
        $builder
            ->where('id', $account->id)
            ->set('date_last_action', time())
            ->update();

        $return = [
            'id'               => (int) $account->id,
            'login'            => $account->login,
            'password'         => $account->password,
            'status'           => $account->status,
            'date_create'      => (int) $account->date_create,
            'date_last_action' => (int) $account->date_last_action,
            'proxy_ip'         => $account->proxy_ip,
            'proxy_login'      => $account->proxy_login,
            'proxy_password'   => $account->proxy_password,
        ];

        return $this->output->collection($return);
    }
}

