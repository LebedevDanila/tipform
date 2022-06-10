<?php namespace App\Libraries\Orders;

/**
 * Библиотека для работы с чеками OFD
 */

class Acquiring {

    public function getMethod($method_id = 0, $sum = 0)
    {
        $this->db    = \Config\Database::connect();
        $agg_methods = $this->db
            ->table('orders_acquiring_agg_methods')
            ->where('orders_acquiring_agg_methods.method_id', $method_id)
            ->where('orders_acquiring_agg_methods.status', '1')
            ->join('orders_acquiring_aggregators', 'orders_acquiring_aggregators.id=orders_acquiring_agg_methods.agg_id', 'left')
            ->select('orders_acquiring_agg_methods.id, orders_acquiring_agg_methods.agg_id, orders_acquiring_aggregators.name')
            ->get(10)->getResult();
        if (empty($agg_methods))
        {
            return [];
        }
        $agg_method = $agg_methods[0];
        if (count($agg_methods) > 1)
        {
            $methods = [];
            foreach ($agg_methods as $row)
            {
                $methods[$row->name] = $row;
            }
            if ($method_id === 1)
            {
                if (! empty($methods['PayKeeperYag']))
                {
                    $agg_method = $methods['PayKeeperYag'];
                }
                else
                {
                    if (! empty($methods['PayKeeper']))
                    {
                        $agg_method = $methods['PayKeeper'];
                    }
                }
                // Условие карт
                if ($sum > 600 && $sum < 3900)
                {
                    if (! empty($methods['Cloudpayments']))
                    {
                        $agg_method = $methods['Cloudpayments'];
                    }
                }
                if ($sum === 290)
                {
                    if (! empty($methods['PayKeeper']))
                    {
                        $agg_method = $methods['PayKeeper'];
                    }
                }
                if (($sum >= 640 && $sum <= 1200) || $sum <= 290)
                {
                    if (! empty($methods['WalletOne']))
                    {
                        $agg_method = $methods['WalletOne'];
                    }
                }
            }
        }
        return $agg_method;
    }
}
