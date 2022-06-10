<?php namespace App\Libraries\Orders;

use \App\Libraries\Utils\Curl;

class WalletOne {

    public function __construct()
    {
        $this->user     = (new \Config\App())->walletone['user'];
        $this->password = (new \Config\App())->walletone['password'];
        $this->token    = false;
        $this->db       = \Config\Database::connect();
        $this->getToken();
    }

    public function getTransactionByID($id = 0)
    {
        if (empty($this->token))
        {
            return false;
        }
        $resp = $this->requests('OpenApi/invoices/' . $id . '/operations', 'GET');
        if (! empty($resp->InvoiceOperations[0]))
        {
            return $resp->InvoiceOperations[0];
        }
        return [];
    }

    /**
     * Возврат средств
     */
    public function refund($id = 0, $amount = 0)
    {
        if (empty($this->token))
        {
            return false;
        }

        $resp = $this->requests('OpenApi/invoices/' . $id, 'GET');
        $resp = $this->requests('OpenApi/invoices/' . $id . '/operations', 'GET');
        if (empty($resp->InvoiceOperations[0]->OperationId))
        {
            return false;
        }
        $resp = $this->requests('OpenApi/payments/refund', 'POST', '{"OperationId":' . $resp->InvoiceOperations[0]->OperationId . '}');
        if (empty($resp))
        {
            return false;
        }
        if (! empty($resp->Error))
        {
            $this->db = \Config\Database::connect();
            $this->db
                ->table('logs_any')
                ->insert([
                    'key'   => 'refund_walletone',
                    'value' => $resp->Error . ' - ' . $resp->ErrorDescription,
                    'date'  => date('Y-m-d H:i:s'),
                ]);
            return false;
        }
        return true;
    }

    private function getToken()
    {
        $token = $this->db
            ->table('orders_settings_walletone_sessions')
            ->where('date_expire >=', date('Y-m-d H:i:s'))
            ->get(1)->getRow();
        if (! empty($token))
        {
            $this->token = $token->token;
            return true;
        }
        $resp = $this->requests('OpenApi/sessions', 'POST', json_encode([
            'Login'    => $this->user,
            'Password' => $this->password,
            'Scope'    => 'All',
        ]));
        if (! empty($resp->Token))
        {
            $this->token = $resp->Token;
            $resp        = $this->requests('OpenApi/sessions/principal', 'POST', '{PrincipalUserId: "'.(new \Config\App())->walletone['id'].'"}');
            if (! empty($resp->Token))
            {
                $expire = strtotime($resp->ExpireDate);
                $this->db
                    ->table('orders_settings_walletone_sessions')
                    ->insert([
                        'token'       => $resp->Token,
                        'date_create' => date('Y-m-d H:i:s'),
                        'date_expire' => date('Y-m-d H:i:s', $expire),
                    ]);
                $this->token = $resp->Token;
                return true;
            }
            else
            {
                $this->token = null;
            }
        }
        return false;
    }

    private function requests($method = '', $met = 'POST', $data = [], $headers = [])
    {
        $this->headers   = [];
        $this->headers[] = 'Accept: application/vnd.wallet.openapi.v1+json';
        $this->headers[] = 'Content-Type: application/vnd.wallet.openapi.v1+json';
        $this->headers[] = 'Accept-Language: ru-RU';
        $this->headers[] = 'Origin: https://www.walletone.com';
        $this->headers[] = 'Referer: https://www.walletone.com/merchant/client/';
        $this->headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36';
        $this->headers[] = 'Cookie: w1:CountryCode=RU; w1merchant:LastLogin=79601359946; _ym_visorc_24181150=w; _icl_current_language=ru; w1_current_language=ru; _gat=1';
        if (! empty($this->token))
        {
            $this->headers[] = 'Authorization: Bearer ' . $this->token;
        }
        else
        {
            $this->headers[] = 'Authorization: Bearer 54344285-82DA-42EA-B7D0-0C9B978FFD89';
        }
        $resp      = (new Curl([
            CURLOPT_CUSTOMREQUEST  => $met,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_CONNECTTIMEOUT => 60,
        ]))->send('https://www.walletone.com/' . $method, $data, $this->headers);
        $json_desp = json_decode($resp);
        if (empty($json_desp))
        {
            return $resp;
        }
        return $json_desp;
    }

}
