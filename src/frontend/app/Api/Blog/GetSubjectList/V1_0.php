<?php namespace App\Api\Blog\GetSubjectList;

use \App\Libraries\Utils\Output;
use Config\Database;

class V1_0
{
    public function __construct()
    {
        $this->output = new Output();
        $this->db     = Database::connect();
    }

    /**
     * Код функции
     */
    public function execute($params = [])
    {
        try {
            $subjects = $this->db
                ->table('blog_subjects')
                ->get()->getResult();
        } catch (\Exception $e) {
            return $this->output->error(14);
        }

        $return = [];
        foreach ($subjects as $row)
        {
            $return[] = [
                'id'               => (int) $row->id,
                'name'             => $row->name,
                'link'             => $row->link,
                'meta_title'       => $row->meta_title,
                'meta_description' => $row->meta_description,
                'meta_keywords'    => $row->meta_keywords,
            ];
        }

        return $this->output->collection($return);
    }
}
