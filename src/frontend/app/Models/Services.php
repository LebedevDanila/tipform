<?php namespace App\Models;

class Services{

    public function __construct()
    {
        $this->db    = \Config\Database::connect();
        $this->cache = \Config\Services::cache();
    }

    public function getServices()
    {
        if (! $return = $this->cache->get('orders_services'))
        {
            $services = $this->db
                ->table('orders_services')
                ->get()->getResult();

            $return_array = [];
            foreach ($services as $row)
            {
                $return_array[$row->id]       = $row;
                $return_array[$row->id]->info = [];
                $data                         = $this->db
                    ->table('orders_services_tags')
                    ->where('service_id', $row->id)
                    ->select('key, value')
                    ->get(1000)->getResult();
                foreach ($data as $info)
                {
                    $return_array[$row->id]->info[$info->key] = $info->value;
                }
            }
            $return = json_encode($return_array);
            $this->cache->save('orders_services', $return, 10);
        }

        $return = json_decode($return);
        return $return;
    }
}
