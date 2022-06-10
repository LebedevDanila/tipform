<?php namespace App\Libraries\Notify;

use \App\Libraries\Utils\Curl;
use \App\Libraries\Utils\Googlestorage;
use Config\Database;

class Email{

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
                'email' => (empty($data['from']['email']) ? 'info@reestrgov.ru' : $data['from']['email']),
                'name'  => (empty($data['from']['name']) ? 'Reestrgov.ru' : $data['from']['name']),
            ],
            'to'           => $to_array,
            'subject'      => $data['subject'],
            'body'         => (array)$data['body'],
            'headers'      => ['reply_to' => (empty($data['reply_to']) ? '' : $data['reply_to'])],
            'attachments'  => (empty($data['attachments']) ? [] : $data['attachments']),
            'access_token' => $this->token,
        ];
        $resp = (new Curl)->send('http://api.kibers.com/email.send.json', $data, [], '', '');
        $resp = json_decode($resp);
        if (! empty($resp->response))
        {
            $time       = time();
            $log_email  = '<!DOCTYPE html><html lang="ru"><head><meta http-equiv=Content-Type content="text/html;charset=UTF-8"></head><body>';
            $log_email .= (empty($data['body']['html']) ? $data['body']['text'] : $data['body']['html']);
            if (! empty($data['attachments']))
            {
                $log_email .= '<br /><br />
					<strong>Файлы:</strong><br /><table border="1" style="border:1px solid; width:100%;border-collapse: collapse;">
					<thead><tr><th style="text-align:center;">id</th><th>name</th>
					<th style="text-align:center;">download</th></tr>
					</thead><tbody>';
                foreach ($data['attachments'] as $k => $file)
                {
                    $log_email .= '<tr>
						<td style="text-align:center;">' . ($k + 1) . '</td>
						<td>' . $file['name'] . '</td>
						<td style="text-align:center;"><a href="' . (empty($file['file']) ? '' : $file['file']) . '">download</a></td>
					</tr>';
                }
                $log_email .= '</tbody>';
            }
            $log_email .= '</body></html>';
            foreach ($resp->response->data->messages as $row)
            {
                $this->db
                    ->table('notify_emails_messages')
                    ->insert([
                        'hash'        => $row->id,
                        'email'       => $row->to,
                        'date_create' => $time,
                        'template'    => $template,
                        'user_id'     => $user_id,
                        'bill_id'     => $bill_id
                    ]);
                $id       = $this->db->insertID();
                $return[] = [
                    'email' => $row->to,
                    'id'    => $id,
                ];
                (new Googlestorage)->put('logs/emails/' . date('Y-m-d', $time) . '/' . $row->id . '.html', $log_email);
            }
            return $return;
        }
        return [];
    }
}
