<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InstagramAccountsTable extends Migration
{
	public function up()
    {
        $this->forge->addField([
            'id'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'login'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
               'type'        => "ENUM('0','1')",
               'default'     => '1',
               'comment'     => 'В работе или нет',
            ],
            'date_create' => [
                'type'        => 'INT',
                'constraint'  => 11,
            ],
            'date_last_action'  => [
                'type'        => 'INT',
                'constraint'  => 11,
            ],
            'proxy' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('status');
        $this->forge->addKey('date_last_action');
        $this->forge->createTable('instagram_accounts', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('instagram_accounts', true);
    }
}
