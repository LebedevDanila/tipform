<?php namespace App\Api\Blog\GetArticleList;

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
        if (empty($params['is_all'])) {
            $request['blog_articles.status'] = '1';
        }

        if(!empty($params['subject_id'])) {
            $request['blog_articles.subject_id'] = $params['subject_id'];
        } else if(!empty($params['subject_link'])) {
            $request['blog_subjects.link'] = $params['subject_link'];
        }

        try {
            $articles = $this->db
                ->table('blog_articles')
                ->select('
                    blog_articles.*,
                    blog_subjects.name AS subject_name,
                    blog_subjects.link AS subject_link
                ')
                ->where($request)
                ->join('blog_subjects', 'blog_subjects.id = blog_articles.subject_id', 'left')
                ->orderBy('blog_articles.id', 'DESC')
                ->get()->getResult();
        } catch (\Exception $e) {
            return $this->output->error(14);
        }

        $return = [];
        foreach ($articles as $row)
        {
            $return[] = [
                'id'               => (int) $row->id,
                'image'            => $row->image,
                'thumbnail'        => $row->thumbnail,
                'title'            => $row->title,
                'link'             => $row->link,
                'text'             => $row->text,
                'date_create'      => (int) $row->date_create,
                'views'            => (int) $row->views,
                'meta_title'       => $row->meta_title,
                'meta_description' => $row->meta_description,
                'meta_keywords'    => $row->meta_keywords,
                'status'           => $row->status === '1',
                'subject_id'       => (int) $row->subject_id,
                'subject_name'     => $row->subject_name,
                'subject_link'     => $row->subject_link,
            ];
        }

        return $this->output->collection($return);
    }
}
