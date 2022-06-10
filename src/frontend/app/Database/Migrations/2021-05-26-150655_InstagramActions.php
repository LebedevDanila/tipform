<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InstagramActions extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'event_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'profile_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'date_create' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'cost' => [
                'type'       => 'FLOAT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('event_id');
        $this->forge->addKey('profile_id');
        $this->forge->addKey('date_create');
        $this->forge->createTable('instagram_actions', true);
        
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('instagram_actions', true);
    }
}
