<?php namespace App\Libraries\Orders;

use \App\Libraries\Orders\NanokassaLibs\NanoFunctions as nanoF;
use \App\Libraries\Orders\NanokassaLibs\NanoParams as nanoP;
use Config\Database;

class Nanokassa {

    public function __construct($account_id = 1)
    {
        $this->db = Database::connect();
        $account  = $this->db
            ->table('orders_acquiring_ofd')
            ->where('id', $account_id)
            ->get(1)->getRow();
        if (! empty($account))
        {
            $this->kassa_id    = $account->kassa_id;
            $this->kassa_token = $account->kassa_token;
            $this->nalog       = $account->nalog;
            $this->account_id  = $account_id;
        }
    }

    /**
     * Отправить чек
     */
    public function sendCheck($bill_id = 0, $refund_id = 0, $priznak_rascheta = 1)
    {
        if (empty($this->kassa_id))
        {
            return false;
        }

        $email = 'empty@reestrgov.ru';
        $test  = 0;

        $this->db
            ->table('orders_billings_ofd')
            ->insert([
                'ofd_id'      => $this->account_id,
                'bill_id'     => $bill_id,
                'type'        => (string)$priznak_rascheta,
                'status'      => '0',
                'date_create' => time(),
            ]);
        $ofd_id = $this->db->insertID();

        $products = [];
        if ($priznak_rascheta === 1)
        {
            $products = $this->db
                ->table('orders_billings_ofd_products')
                ->where('bill_id', $bill_id)
                ->orderBy('id', 'asc')
                ->get(1000)->getResult();
            foreach ($products as $row)
            {
                $this->db
                    ->table('orders_billings_ofd_options')
                    ->insert([
                        'bill_id'    => $bill_id,
                        'ofd_id'     => $ofd_id,
                        'product_id' => $row->id,
                    ]);
            }
        }
        elseif ($priznak_rascheta === 2)
        {
            $options = $this->db
                ->table('orders_billings_refund_options')
                ->where('refund_id', $refund_id)
                ->get()->getResult();
            foreach ($options as $row)
            {
                $products[] = $this->db
                    ->table('orders_billings_ofd_products')
                    ->where('id', $row->product_id)
                    ->get(1)->getRow();
                $this->db
                    ->table('orders_billings_ofd_options')
                    ->insert([
                        'bill_id'    => $bill_id,
                        'ofd_id'     => $ofd_id,
                        'product_id' => $row->product_id,
                    ]);
            }
        }

        $price = 0;
        $array = [];
        foreach ($products as $row)
        {
            $price  += $row->sum;
            $array[] = [
                'name_tovar'                => $row->name,
                'price_piece_bez_skidki'    => $row->sum . '.00',
                'kolvo'                     => 1,
                'price_piece'               => $row->sum . '.00',
                'summa'                     => $row->sum . '.00',
                'stavka_nds'                => 6,
                'priznak_sposoba_rascheta'  => 1,
                'priznak_predmeta_rascheta' => 4,
                'priznak_agenta'            => 'none',
            ];
        }
        $price = $price . '.00';

        $this->db
            ->table('orders_billings_ofd')
            ->where('id', $ofd_id)
            ->update([
                'amount' => $price,
            ]);

        $request = [
            'kassaid'         => $this->kassa_id,
            'kassatoken'      => $this->kassa_token,
            'cms'             => 'wordpress',
            'check_send_type' => 'email',
            'products_arr'    => $array,
            'oplata_arr'      => [
                'rezhim_nalog'     => (int)$this->nalog,
                'money_nal'        => 0,
                'money_electro'    => $price,
                'money_predoplata' => 0,
                'money_postoplata' => 0,
                'money_vstrecha'   => 0,
                'client_email'     => $email,
            ],
            'itog_arr'        => [
                'priznak_rascheta' => $priznak_rascheta,
                'itog_cheka'       => $price,
            ],
        ];

        $request       = json_encode($request);
        $firstcrypt    = nanoF::crypt_nanokassa_first($request);
        $returnDataAB  = $firstcrypt[0];
        $returnDataDE  = $firstcrypt[1];
        $request2      = '{
        	"ab":"' . $returnDataAB . '",
        	"de":"' . $returnDataDE . '",
        	"kassaid":"' . $this->kassa_id . '",
        	"kassatoken":"' . $this->kassa_token . '",
        	"test":"' . $test . '"
        }';
        $secondcrypt   = nanoF::crypt_nanokassa_second($request2);
        $returnDataAAB = $secondcrypt[0];
        $returnDataDE2 = $secondcrypt[1];
        $request3      = '{
        	"aab":"' . $returnDataAAB . '",
        	"dde":"' . $returnDataDE2 . '",
        	"test":"' . $test . '"
        }';
        $url           = nanoP::URL_TO_SEND_TO_NANOKASSA;
        $answer        = nanoF::sndcurl($request3, $url);

        $answer = json_decode($answer);

        if (! empty($answer->status) && $answer->status === 'success')
        {
            $this->db
                ->table('orders_billings_ofd')
                ->where('id', $ofd_id)
                ->update([
                    'status' => '1',
                    'nuid'   => $answer->nuid,
                    'qnuid'  => $answer->qnuid,
                ]);
        }

        return $answer;
    }

    /**
     * Возврат платежа
     */
    public function refund($bill_id = 0, $refund_id = 0, $priznak_rascheta = 2)
    {
        return $this->sendCheck($bill_id, $refund_id, $priznak_rascheta);
    }
}
