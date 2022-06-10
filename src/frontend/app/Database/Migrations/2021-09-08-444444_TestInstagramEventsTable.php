<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TestInstagramEventsTable extends Migration
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
                'account_id'  => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'text'        => [
                    'type'    => 'TEXT',
                    'comment' => 'Текст с информацией',
                ],
                'type'        => [
                    'type'    => "ENUM('app','background')",
                    'comment' => 'app - действия приложения; background - фоновые действия',
                ],
                'date_create' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'status'      => [
                    'type'    => "ENUM('0','1')",
                    'default' => '0',
                    'comment' => 'Выполнился или нет',
                ],
            ]
        );

        $this->forge->addKey('id', true);
        $this->forge->addKey('account_id');
        $this->forge->addKey('type');
        $this->forge->addKey('date_create');
        $this->forge->addKey('status');
        $this->forge->createTable('test_instagram_events', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('test_instagram_events', true);
    }
}