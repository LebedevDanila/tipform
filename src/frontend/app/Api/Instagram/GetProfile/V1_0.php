<?php namespace App\Api\Instagram\GetProfile;

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
        if(empty($params['username'])) {
            return $this->output->error(11);
        }

        $profile = $this->db
            ->table('instagram_profiles')
            ->where('username', $params['username'])
            ->get()->getRow();
        if (!empty($profile))
        {
            $profile = [
                'id'          => (int) $profile->id,
                'unique_id'   => (int) $profile->unique_id,
                'username'    => $profile->username,
                'biography'   => $profile->biography,
                'picture'     => $profile->picture,
                'followers'   => (int) $profile->followers,
                'following'   => (int) $profile->following,
                'verified'    => (int) $profile->verified ? true : false,
                'private'     => (int) $profile->private  ? true : false,
                'media_count' => (int) $profile->media_count,
                'date_update' => (int) $profile->date_update,
            ];
        }

        return $this->output->collection($profile);
    }
}

