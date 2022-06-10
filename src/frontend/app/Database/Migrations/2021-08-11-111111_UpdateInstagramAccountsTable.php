<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateInstagramAccountsTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('instagram_accounts');

        $this->forge->addField(
            [
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'login' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'unique'     => true,
                ],
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'status'           => [
                    'type'    => "ENUM('0','1')",
                    'default' => '1',
                    'comment' => 'В работе или нет',
                ],
                'date_create' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'date_last_action' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'proxy_ip' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                ],
                'proxy_login' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                ],
                'proxy_password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                ],
            ]
        );
        $this->forge->addKey('id', true);
        $this->forge->addKey('status');
        $this->forge->addKey('date_last_action');
        $this->forge->createTable('instagram_accounts', true);

        $data = [
            [
                'login'            => 'milenasilnaia',
                'password'         => 'mnogoto4ie123',
                'status'           => '1',
                'date_create'      => 0,
                'date_last_action' => 0,
                'proxy_ip'         => '92.255.253.185:12501',
                'proxy_login'      => 'osdd3244',
                'proxy_password'   => 'k2kmrtde',
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
