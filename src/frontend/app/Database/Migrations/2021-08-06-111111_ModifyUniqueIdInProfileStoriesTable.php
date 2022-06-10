<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUniqueIdInProfileStoriesTable extends Migration
{
    public function up()
    {
        $fields = [
            'unique_id' => [
                'name'       => 'unique_id',
                'type'       => 'VARCHAR',
                'constraint' => 55,
            ],
        ];
        $this->forge->modifyColumn('instagram_profiles_stories', $fields);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        //
    }
}
