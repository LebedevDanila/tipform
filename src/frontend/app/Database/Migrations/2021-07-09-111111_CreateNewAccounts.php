<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNewAccounts extends Migration
{
    public function up()
    {
        $data = [
            [
                'login'            => 'zhmih_valera1234',
                'password'         => 'qwerty1234',
                'status'           => '1',
                'date_create'      => 1621952850,
                'date_last_action' => 1621952867,
                'proxy'            => '130.193.44.116:51958',
            ],
        ];

        $this->db = \Config\Database::connect();
        $this->db->table('instagram_accounts')->insertBatch($data);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('instagram_accounts', true);
    }
}
