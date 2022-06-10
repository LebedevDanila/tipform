<?php namespace App\Controllers\Popups;

use \App\Libraries\Api;
use \App\Libraries\Utils\Curl;
use App\Models\User;

class Auth extends BasePopup
{
    public function __construct()
    {
    }

    public function getPopup()
    {
        $types = [
            'count',
            'plus',
        ];
        shuffle($types);
        $type = $types[0];
        $data = [
            'content' => view_popup('auth', ['type' => $type, 'session' => (empty($this->user) ? 0 : 1)]),
        ];

        return $this->response($data);
    }

    public function sendFormStep1()
    {
        if (empty($_POST['data']))
        {
            return $this->error(400);
        }
        $params = json_decode(base64_decode($_POST['data']), true);
        if (empty($params) || empty($params['phone']))
        {
            return $this->error(400);
        }

        $phone = str_replace([' ', '+', '(', ')', '-', '_'], ['', '', '', '', '', ''], $params['phone']);

        $resp = (new Api)->call('passport.authByPhone', [
            'phone' => $phone,
        ]);
        if (! empty($resp->error))
        {
            return $this->response(['error' => $resp->error->error_msg]);
        }

        return $this->response($resp->response->data);
    }

    public function sendFormStep2()
    {
        if (empty($_POST['data']))
        {
            return $this->error(400);
        }
        $params = json_decode(base64_decode($_POST['data']), true);
        if (empty($params) || empty($params['code']) || empty($params['key']))
        {
            return $this->error(400);
        }

        $code = str_replace([' ', '-'], '', $params['code']);

        $resp = (new Api)->call('passport.authCheckCode', [
            'key'       => $params['key'],
            'code'      => $code,
            'ip'        => $this->request->getIPAddress(),
            'useragent' => (empty($_SERVER['HTTP_USER_AGENT']) ? 'none' : $_SERVER['HTTP_USER_AGENT']),
        ]);

        if (! empty($resp->error))
        {
            return $this->response(['error' => ['code' => $resp->error->error_code, 'msg' => $resp->error->error_msg]]);
        }

        $_SESSION['user_session'] = [
            'session_id'  => $resp->response->data->session_id,
            'date_expire' => strtotime($resp->response->data->date_expire),
        ];

        $data             = $resp->response->data;
        $data->front_data = base64_encode(json_encode((new User())->getSessionUser()));
        return $this->response($data);
    }

    public function sendFormStep3()
    {
        if (empty($_POST['data']))
        {
            return $this->error(400);
        }
        $params = json_decode(base64_decode($_POST['data']), true);
        if (empty($params))
        {
            return $this->error(400);
        }
        if (empty($_SESSION['user_session']['session_id']))
        {
            return $this->error(400);
        }

        $data = [
            'session_id' => $_SESSION['user_session']['session_id'],
            'settings'   => $params,
        ];
        $resp = (new Api)->call('passport.userUpdateSettings', $data);

        if (! empty($resp->error))
        {
            return $this->response(['error' => ['code' => $resp->error->error_code, 'msg' => $resp->error->error_msg]]);
        }

        return $this->response($resp->response->data);
    }

}