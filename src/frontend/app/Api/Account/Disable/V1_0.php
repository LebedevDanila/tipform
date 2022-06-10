<?php namespace App\Api\Account\Disable;

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
        if(!isset($params['id']))
        {
            return $this->output->error(11);
        }

        try {
            $this->db
                ->table('instagram_accounts')
                ->where('id', $params['id'])
                ->set('status', '0')
                ->update();
        } catch (\Exception $e)
        {
            return $this->output->error(13);
        }

        return $this->output->collection(['status' => true]);
    }
}
