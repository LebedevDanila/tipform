<?php namespace App\Libraries\Notify;



use Config\Database;

class Sms{

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function send($data = [])
    {
        $operator = $this->db
            ->table('notify_sms_operators')
            ->where('status', '1')
            ->get(1)->getRow();
        if (empty($operator))
        {
            return false;
        }

        $namespace = '\\App\\Libraries\\Notify\\SmsLibraries\\' . $operator->library;
        $resp      = (new $namespace)->send($data);

        if (empty($resp))
        {
            return false;
        }

        $this->db
            ->table('notify_sms_messages')
            ->insert([
                 'user_id'             => (! empty($data['user_id']) ? $data['user_id'] : null),
                 'bill_id'             => (! empty($data['bill_id']) ? $data['bill_id'] : null),
                 'operator_id'         => $operator->id,
                 'operator_service_id' => $resp['id'],
                 'phone'               => $data['phone'],
                 'text'                => $data['text'],
                 'status'              => $resp['status'],
                 'cost'                => $resp['cost'],
                 'date_create'         => time(),
             ]);

        $return = [
            'id'        => (int)$this->db->insertID(),
            'status'    =>  $resp['status']
        ];

        return $return;
    }
}