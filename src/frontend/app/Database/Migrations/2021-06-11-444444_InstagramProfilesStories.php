<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InstagramProfilesStories extends Migration
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
            'profile_id' => [
                'type'       => 'INT',
                'constraint' => 11,
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
            'type' => [
               'type'        => "ENUM('video','image')",
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('profile_id');
        $this->forge->addKey('date_create');
        $this->forge->createTable('instagram_profiles_stories', true);
        
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('instagram_profiles_stories', true);
    }
}
