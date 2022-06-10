<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TestInstagramStoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'id'     => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'profile_id'  => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'unique_id'   => [
                    'type'       => 'VARCHAR',
                    'constraint' => 55,
                ],
                'preview'     => [
                    'type'    => 'TEXT',
                    'comment' => 'Начальное изображение',
                    'null'    => true,
                ],
                'content'     => [
                    'type'    => 'TEXT',
                    'comment' => 'Контент изображения/видео',
                ],
                'date_create' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'date_expire' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'date_public' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'type'        => [
                    'type' => "ENUM('video','image')",
                ],
            ]
        );

        $this->forge->addKey('id', true);
        $this->forge->addKey('profile_id');
        $this->forge->addKey('unique_id');
        $this->forge->addKey('date_create');
        $this->forge->addKey('date_expire');
        $this->forge->addKey('date_public');
        $this->forge->createTable('test_instagram_stories', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('test_instagram_stories', true);
    }
}