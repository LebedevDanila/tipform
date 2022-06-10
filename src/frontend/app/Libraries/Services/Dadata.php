<?php namespace App\Libraries\Services;

use \App\Libraries\Utils\Curl;

class Dadata
{

    public function getAddress($search = '')
    {
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Token '.DADATA_KEY,
        ];
        $resp = (new Curl())->send(
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address',
            json_encode(['query' => $search]),
            $headers
        );
        if (empty($resp)) {
            return [];
        }
        $resp = json_decode($resp);
        return $resp;
    }

    public function clean($search = "")
    {
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Token '.DADATA_KEY,
            "X-Secret: ".DADATA_KEY_STANDART
        ];
        $resp = (new Curl())->send('https://cleaner.dadata.ru/api/v1/clean/address', json_encode([$search]), $headers);
        if (empty($resp)) {
            return [];
        }
        $resp = json_decode($resp);
        return $resp;
    }
}
