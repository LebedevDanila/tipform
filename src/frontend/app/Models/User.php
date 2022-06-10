<?php namespace App\Models;

use \App\Libraries\Api;
use Config\Database;

class User{

    public function getSessionUser()
    {
        if (empty($_SESSION['user_session']['session_id']))
        {
            return [];
        }
        $this->cache = \Config\Services::cache();
        if ($user = $this->cache->get('user.session-' . $_SESSION['user_session']['session_id']))
        {
            return $user;
        }

        $resp = (new Api)->call('passport.userGet', [
            'session_id' => $_SESSION['user_session']['session_id'],
        ]);

        if (! empty($resp->error))
        {
            unset($_SESSION['user_session']);
            return [];
        }

        $data              = $resp->response->data;
        $data->blog_author = [];

        $resp = (new Api)->call('blog.authorGet', [
            'user_id' => $data->general->id,
        ]);
        if (! empty($resp->response->data))
        {
            $data->blog_author = $resp->response->data;
        }

        $this->cache->save('user.session-' . $_SESSION['user_session']['session_id'], $data, 60);
        return $data;
    }

    public function getUserBySession($session_id = '')
    {
        $this->db     = Database::connect();
        $time    = time();
        $session = $this->db
            ->table('passport_users_sessions')
            ->where('session_id', $session_id)
            ->get(1)->getRow();
        if (empty($session))
        {
            return ['error' => 503];
        }

        if ($time > $session->date_expire)
        {
            return ['error' => 504];
        }

        $user = $this->db
            ->table('passport_users')
            ->where('id', $session->user_id)
            ->get(1)->getRow();

        if (empty($user))
        {
            return ['error' => 1];
        }
        $data = [
            'session' => $session,
            'user'    => $user,
        ];

        return $data;
    }

}
