<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BlogSubjects extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
            ],
            'link' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'unique'     => true,
            ],
            'meta_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'meta_description' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'meta_keywords' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('blog_subjects', true);
        

        $data = [
            [
                'name' => 'Новости',
                'link' => 'novosti',
            ],
            [
                'name' => 'Интересное',
                'link' => 'interesnoe',
            ],
            [
                'name' => 'Инструкции',
                'link' => 'instrukcii',
            ],
        ];

        $this->db = \Config\Database::connect();
        $this->db->table('blog_subjects')->insertBatch($data);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('blog_subjects', true);
    }
}
