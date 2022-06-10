<?php namespace App\Api\Blog\GetArticle;

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

        if (isset($params['subject_link'])) {
            $request['blog_subjects.link'] = $params['subject_link'];
        } else {
            return $this->output->error(11);
        }

        if(isset($params['id'])) {
            $request['blog_articles.id'] = $params['id'];
        } else if(isset($params['link'])) {
            $request['blog_articles.link'] = $params['link'];
        } else {
            return $this->output->error(11);
        }

        try {
            $article = $this->db
                ->table('blog_articles')
                ->select('
                    blog_articles.*,
                    blog_subjects.name AS subject_name,
                    blog_subjects.link AS subject_link,
                ')
                ->where($request)
                ->join('blog_subjects', 'blog_subjects.id = blog_articles.subject_id', 'left')
                ->get()->getRow();
        } catch (\Exception $e) {
            return $this->output->error(14);
        }
        if(!$article) {
            return $this->output->error(13);
        }

        if(!empty($params['is_view']) && $params['is_view'] === true) {
            $this->db
                ->table('blog_articles')
                ->where('id', $article->id)
                ->set('views', 'views+1', false)
                ->update();
        }

        $return = [
            'id'               => (int) $article->id,
            'image'            => $article->image,
            'thumbnail'        => $article->thumbnail,
            'title'            => $article->title,
            'link'             => $article->link,
            'text'             => $article->text,
            'date_create'      => (int) $article->date_create,
            'views'            => (int) $article->views,
            'meta_title'       => $article->meta_title,
            'meta_description' => $article->meta_description,
            'meta_keywords'    => $article->meta_keywords,
            'subject_id'       => (int) $article->subject_id,
            'subject_name'     => $article->subject_name,
            'subject_link'     => $article->subject_link,
        ];

        return $this->output->collection($return);
    }
}
