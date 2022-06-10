<?php namespace App\Api\Account\Delete;

use \App\Libraries\Utils\Output;
use Config\Database;

class V1_0
{
    public function __construct()
    {
        $errors = [
            413 => 'Такого аккаунта не существует',
        ];
        $this->output = new Output($errors);
        $this->db     = Database::connect();
    }

    /**
     * Код функции
     */
    public function execute($params = [])
    {
        if(empty($params['id']))
        {
            return $this->output->error(11);
        }

        $account = $this->db
            ->table('instagram_accounts')
            ->where('id', $params['id'])
            ->get()->getRow();
        if(!$account)
        {
            return $this->output->error(413);
        }

        try {
            $this->db
                ->table('instagram_accounts')
                ->where('id', $params['id'])
                ->delete();
        } catch(\Exception $e)
        {
            return $this->output->error(13);
        }

        $return = [
            'status' => 'OK',
        ];
        return $this->output->collection(['status' => true]);
    }
}
