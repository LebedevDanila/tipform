<?php namespace App\Api\Blog\GetSubject;

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
        $request = [];
        if(!empty($params['id'])) {
            $request['id'] = $params['id'];
        }
        else if(!empty($params['link'])) {
            $request['link'] = $params['link'];
        }
        else {
            return $this->output->error(11);
        }

        try {
            $subject = $this->db
                ->table('blog_subjects')
                ->where($request)
                ->get()->getRow();
        } catch (\Exception $e) {
            return $this->output->error(14);
        }

        $return = [
            'id'               => (int) $subject->id,
            'name'             => $subject->name,
            'link'             => $subject->link,
            'meta_title'       => $subject->meta_title,
            'meta_description' => $subject->meta_description,
            'meta_keywords'    => $subject->meta_keywords,
        ];

        return $this->output->collection($return);
    }
}
