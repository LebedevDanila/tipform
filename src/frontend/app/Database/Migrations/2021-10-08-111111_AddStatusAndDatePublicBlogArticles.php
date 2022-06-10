<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusAndDatePublicBlogArticles extends Migration
{
	public function up()
	{
        $fields = [
            'date_public' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'date_create',
            ],
            'status' => [
                'type'       => "ENUM('1','0')",
                'default'    => '0',
            ]
        ];
        $this->forge->addColumn('blog_articles', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
