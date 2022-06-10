<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddThumbnailColumnInBlogArticlesTable extends Migration
{
	public function up()
	{
        $fields = [
            'thumbnail' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
                'after'      => 'image',
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
