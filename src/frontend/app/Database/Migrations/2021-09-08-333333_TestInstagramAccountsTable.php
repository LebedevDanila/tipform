<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TestInstagramAccountsTable extends Migration
{
    public function up()
    {
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
                'useragent' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                ],
            ]
        );
        $this->forge->addKey('id', true);
        $this->forge->addKey('status');
        $this->forge->addKey('date_last_action');
        $this->forge->createTable('test_instagram_accounts', true);

        $data = [
            [
                'login'            => 'glam_rock_boy',
                'password'         => 'Vcxz2149',
                'status'           => '1',
                'date_create'      => 0,
                'date_last_action' => 0,
                'proxy_ip'         => '77.51.189.183:12536',
                'proxy_login'      => 'y74af7o2',
                'proxy_password'   => 'sn6mh7ut',
                'useragent'        => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 YaBrowser/21.8.1.468 Yowser/2.5 Safari',
            ],
        ];

        $this->db = \Config\Database::connect();
        $this->db->table('test_instagram_accounts')->insertBatch($data);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('test_instagram_accounts', true);
    }
}