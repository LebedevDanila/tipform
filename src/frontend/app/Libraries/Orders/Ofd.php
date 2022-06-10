<?php namespace App\Libraries\Orders;

/**
 * Библиотека для работы с чеками OFD
 */

class Ofd {

    public function createProducts($bill_id = 0, $products = [])
    {
        $this->db = \Config\Database::connect();
        foreach ($products as $row)
        {
            $data = [
                'bill_id' => $bill_id,
                'sum'     => $row['price'],
                'name'    => $this->getText($row),
            ];
            if (! empty($row['service_id']))
            {
                $data['service_id'] = $row['service_id'];
            }
            $this->db
                ->table('orders_billings_ofd_products')
                ->insert($data);
        }
        return true;
    }

    public function getKassaIdByBillingId($bill_id = 0)
    {
        $this->db = \Config\Database::connect();
        $ofd_id   = 0;
        $bill     = $this->db
            ->table('orders_billings')
            ->where('id', $bill_id)
            ->get(1)->getRow();
        if (empty($bill->acq_agg_id))
        {
            return $ofd_id;
        }
        $aggregator = $this->db
            ->table('orders_acquiring_aggregators')
            ->where('id', $bill->acq_agg_id)
            ->get(1)->getRow();
        if (empty($aggregator->account_id) || $aggregator->ofd == '0')
        {
            return $ofd_id;
        }
        $account = $this->db
            ->table('orders_acquiring_accounts')
            ->where('id', $aggregator->account_id)
            ->get(1)->getRow();
        if (empty($account->ofd_id))
        {
            return $ofd_id;
        }
        return $account->ofd_id;
    }

    private function getText($data = [])
    {
        $text = '';
        switch($data['type']){
            case 'service':
                $text = 'Инф. сведения об объекте недвиж.';
                if (! empty($data['egrn']))
                {
                    $explode = explode(':', $data['egrn']);
                    $text   .= ' №' . $explode[0] . '-' . $explode[1] . '/' . (empty($explode[3]) ? "00" : $explode[3]) . '.';
                }
                if (! empty($data['service_id']))
                {
                    $text .= ' Услуга №' . $data['service_id'];
                }
                break;
        }

        return $text;
    }
}
