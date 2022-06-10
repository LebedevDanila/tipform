<?php namespace App\Models;

class Payments{

    public function __construct()
    {
        $this->db    = \Config\Database::connect();
        $this->cache = \Config\Services::cache();
    }

    public function getPayMethods()
    {
        if (! $methods = $this->cache->get('orders_payMethods'))
        {
            $methods_array = $this->db
                ->table('orders_acquiring_methods')
                ->orderBy('priority', 'asc')
                ->select('id, name')
                ->get()->getResult();
            $methods       = [];

            foreach ($methods_array as $row)
            {
                $check = $this->db
                    ->table('orders_acquiring_agg_methods')
                    ->where('method_id', $row->id)
                    ->where('status', '1')
                    ->select('id')
                    ->get(1)->getRow();
                if (! empty($check))
                {
                    $row->id   = (int)$row->id;
                    $methods[] = $row;
                }
            }
            $methods = json_encode($methods);
            $this->cache->save('orders_payMethods', $methods, 10);
        }

        $methods = json_decode($methods);
        return $methods;
    }
}
