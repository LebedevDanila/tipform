<?php namespace App\Libraries\Services;

class IpApi
{

    public function getInfoIP($ip = "")
    {
        $resp = (new \App\Libraries\Utils\Curl())->send('http://ip-api.com/json/' . $ip);

        $resp = json_decode($resp);
        if (empty($resp)) {
            return false;
        }

        return $resp;
    }
}
