<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMetaSubjects extends Migration
{
    public function up()
    {
        $this->db = \Config\Database::connect();
        $this->db
            ->table('blog_subjects')
            ->where('link', 'novosti')
            ->set([
                'meta_title'       => 'Новости Инстаграмм - Последние свежие новости на сегодня',
                'meta_description' => 'Новости про Инстаграмм - обновления, лайфхаки, инструкции и другие свежие новости 2021 года',
            ])
            ->update();

        $this->db
            ->table('blog_subjects')
            ->where('link', 'interesnoe')
            ->set([
                'meta_title'       => 'Интересные новости instaProfi и Инстаграмма',
                'meta_description' => 'Самые популярные и интересные новости instaProfi и Инстаграмма 2021 года',
            ])
            ->update();

        $this->db
            ->table('blog_subjects')
            ->where('link', 'instrukcii')
            ->set([
                'meta_title'       => 'Инструкции instaprofi - пошаговые действия',
                'meta_description' => 'Пошаговые алгоритмы для просмотра историй Инстаграмм анонимно и новых функций в Инстаграмм 2021 года',
            ])
            ->update();
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('instagram_accounts', true);
    }
}
