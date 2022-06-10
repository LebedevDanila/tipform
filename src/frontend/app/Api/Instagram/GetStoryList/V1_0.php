<?php namespace App\Api\Instagram\GetStoryList;

use \App\Libraries\Utils\Output;

class V1_0
{
    public function __construct()
    {
        $this->output = new Output();
        $this->db     = \Config\Database::connect();
    }

    /**
     * Код функции
     */
    public function execute($params = [])
    {
        if( ! isset($params['profile_id'])) {
            return $this->output->error(11);
        }
        
        $stories = $this->db
            ->table('instagram_stories')
            ->where('profile_id', $params['profile_id'])
            ->orderBy('id', 'DESC')
            ->get()->getResult();
        if ( ! empty($stories)) {
            $data = [];
            foreach ($stories as $row) {
                $data[] = [
                    'unique_id'   => $row->unique_id,
                    'preview'     => $row->preview,
                    'content'     => $row->content,
                    'date_create' => (int) $row->date_create,
                    'date_expire' => (int) $row->date_expire,
                    'date_public' => (int) $row->date_public,
                    'type'        => $row->type,
                ];
            }
            $stories = $data;
        }

        return $this->output->collection($stories);
    }
}
