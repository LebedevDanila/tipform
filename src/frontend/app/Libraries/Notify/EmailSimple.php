<?php namespace App\Libraries\Notify;

use \App\Libraries\Utils\Curl;
use \App\Libraries\Utils\Googlestorage;
use Config\Database;

class EmailSimple
{

    public function __construct()
    {
        $this->token = KIBERS_TOKEN;
        $this->db    = Database::connect();
    }

    public function send($data = [], $template = null, $user_id = null, $bill_id = null)
    {
        $to_array = [];
        foreach ($data['to'] as $row)
        {
          $to_array[]['email'] = $row;
        }

        $data = [
          'from'         => [
            'email' => (empty($data['from']['email']) ? 'lebedev_web@mail.ru' : $data['from']['email']),
            'name'  => (empty($data['from']['name']) ? 'Instaprofi.ru' : $data['from']['name']),
          ],
          'to'           => $to_array,
          'subject'      => $data['subject'],
          'body'         => (array)$data['body'],
          'headers'      => ['reply_to' => (empty($data['reply_to']) ? '' : $data['reply_to'])],
          'attachments'  => (empty($data['attachments']) ? [] : $data['attachments']),
          'access_token' => $this->token,
        ];

        $resp = (new Curl)->send('http://api.kibers.com/email.send.json', $data, [], '', '');
        return $resp;

    }
}
