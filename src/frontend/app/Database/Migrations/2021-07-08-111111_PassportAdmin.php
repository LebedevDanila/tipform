<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PassportAdmin extends Migration
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
            'login' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('login');
        $this->forge->createTable('passport_admin', true);

        $data = [
            [
                'login'    => 'admin',
                'password' => 'rgpoqz',
            ],
        ];

        $this->db = \Config\Database::connect();
        $this->db->table('passport_admin')->insertBatch($data);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('passport_admin', true);
    }
}
