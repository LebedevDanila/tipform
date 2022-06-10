<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TestInstagramProfilesTable extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'id'          => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'unique_id'   => [
                    'type'       => 'VARCHAR',
                    'constraint' => 55,
                ],
                'username'    => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'biography'   => [
                    'type'      => 'TEXT',
                    'null'      => true,
                ],
                'picture'     => [
                    'type' => 'TEXT',
                ],
                'followers'   => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'following'   => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'verified'    => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                ],
                'private'     => [
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
                'date_update' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 0,
                ],
            ]
        );

        $this->forge->addKey('id', true);
        $this->forge->addKey('unique_id');
        $this->forge->addKey('username');
        $this->forge->addKey('date_create');
        $this->forge->createTable('test_instagram_profiles', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('test_instagram_profiles', true);
    }
}