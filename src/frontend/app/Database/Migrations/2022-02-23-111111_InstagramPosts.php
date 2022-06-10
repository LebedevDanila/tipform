<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InstagramPosts extends Migration
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
                'date_create' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'date_expire' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
            ]
        );

        $this->forge->addKey('id', true);
        $this->forge->addKey('profile_id');
        $this->forge->addKey('unique_id');
        $this->forge->addKey('date_create');
        $this->forge->addKey('date_expire');
        $this->forge->createTable('instagram_posts', true);

        $this->forge->addField(
            [
                'id'     => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'post_id'  => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'unique_id'   => [
                    'type'       => 'VARCHAR',
                    'constraint' => 55,
                ],
                'content'     => [
                    'type'    => 'TEXT',
                    'comment' => 'Контент изображения/видео',
                ],
                'type'        => [
                    'type' => "ENUM('video','image')",
                ],
            ]
        );

        $this->forge->addKey('id', true);
        $this->forge->addKey('post_id');
        $this->forge->addKey('unique_id');
        $this->forge->createTable('instagram_posts_content', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('instagram_posts', true);
        $this->forge->dropTable('instagram_posts_content', true);
    }
}


