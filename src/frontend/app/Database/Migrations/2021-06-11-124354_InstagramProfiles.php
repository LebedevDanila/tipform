<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InstagramProfiles extends Migration
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
            'unique_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'biography' => [
                'type'       => 'TEXT',
                'null'       => true,
                'charset'    => 'utf8mb4_general_ci'
            ],
            'picture' => [
                'type'       => 'TEXT',
            ],
            'followers' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'following' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'verified' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
            ],
            'private' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
            ],
            'media_count' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'date_create' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('unique_id');
        $this->forge->addKey('username');
        $this->forge->addKey('date_create');
        $this->forge->createTable('instagram_profiles', true);
        
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('instagram_profiles', true);
    }
}
