<?php namespace App\Libraries\Orders;

use \App\Libraries\Utils\Curl;

class Cloudpayments {

    public function __construct()
    {
        $this->api_key   = (new \Config\App())->cloudpayment['api_key'];
        $this->public_id = (new \Config\App())->cloudpayment['public_id'];
    }

    /**
     * Возврат средств пользователю
     */
    public function refund($id = 0, $amount = 0)
    {
        $resp = $this->send('payments/refund', ['TransactionId' => $id, 'Amount' => $amount]);
        if(!empty($resp->Success) && $resp->Success == TRUE){
            return true;
        }
        return false;
    }

    public function getTransactionByID($id=0)
    {
        $resp = $this->send('payments/get', ['TransactionId' => $id]);
        if(!empty($resp->Model)){
            return $resp->Model;
        }
        return [];

    }

    /**
     * Выгрузить все транзакции за дату
     */
    public function getTransactions($date="2018-11-30")
    {
        $resp = $this->send('payments/list', ['Date' => $date]);
        if(!empty($resp->Model)){
            return $resp->Model;
        }
        return [];
    }

    /**
     * Старт сессии ApplePay
     */
    public function applePayStartSession($url="")
    {
        $resp = $this->send('applepay/startsession', ['ValidationUrl' => $url]);
        if(!empty($resp->Model)){
            return $resp;
        }
        return [];
    }

    /**
     * Старт сессии ApplePay
     */
    public function applePayPay($data=[])
    {
        $resp = $this->send('payments/cards/charge', $data);
        if(!empty($resp->Model)){
            return $resp;
        }
        return [];
    }

    private function send($method="", $data=[])
    {
        $headers = [
            'Content-Type: application/json',
            'Authorization: Basic '.base64_encode($this->public_id.":".$this->api_key)
        ];
        $resp = (new Curl())->send('https://api.cloudpayments.ru/'.$method, json_encode($data), $headers);
        return json_decode($resp);
    }

}