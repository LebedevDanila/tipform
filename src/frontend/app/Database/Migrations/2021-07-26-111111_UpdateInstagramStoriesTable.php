<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateInstagramStoriesTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('instagram_profiles_stories');

        $this->forge->addField([
            'id'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'profile_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'unique_id' => [
                'type'       => 'BIGINT',
            ],
            'preview' => [
                'type'       => 'TEXT',
                'comment'    => 'Начальное изображение',
                'null'       => true,
            ],
            'content' => [
                'type'       => 'TEXT',
                'comment'    => 'Контент изображения/видео',
            ],
            'date_create' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'date_expire' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'type' => [
                'type'       => "ENUM('video','image')",
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('profile_id');
        $this->forge->addKey('unique_id');
        $this->forge->addKey('date_create');
        $this->forge->addKey('date_expire');
        $this->forge->createTable('instagram_profiles_stories', true);

    }

    //--------------------------------------------------------------------

    public function down()
    {

    }
}

