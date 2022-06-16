<?php
namespace App\Libraries\Utils;

class Curl
{
    private $curl_config = [];

    public function __construct(array $config = null)
    {
        $this->curl_config[CURLOPT_CONNECTTIMEOUT] = 15;
        $this->curl_config[CURLOPT_TIMEOUT]        = 30;
        $this->curl_config[CURLOPT_HEADER]         = 0;
        $this->curl_config[CURLOPT_SSL_VERIFYPEER] = 0;
        $this->curl_config[CURLOPT_SSL_VERIFYHOST] = 0;
        if (is_array($config) && ! is_null($config)) {
            $this->setConfig($config);
        }
    }

    public function send($url = '', $post = [], $headers = [], $cookie = '', $proxy = '') // 37.48.118.4:13150
    {
        $is_user_agent = 0;
        foreach ($headers as $row) {
            if (preg_match('#User-Agent#Us', $row)) {
                $is_user_agent = 1;
            }
        }
        if ($is_user_agent === 0) {
            $headers[] = 'User-Agent: ' . $this->useragent();
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        if ( ! empty($post)) {
            if ( ! is_string($post)) {
                $post = http_build_query($post);
            }
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if ( ! empty($proxy)) {
            if (is_array($proxy)) {
                curl_setopt($ch, CURLOPT_PROXY, $proxy['ip']);
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy['login'] . ':' . $proxy['password']);
            } else {
                curl_setopt($ch, CURLOPT_PROXY, $proxy);
            }
        }
        if ($cookie !== '') {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        foreach ($this->curl_config as $name => $value) {
            curl_setopt($ch, $name, $value);
        }
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    public function setConfig($name, $value = null)
    {
        if (is_array($name) && is_null($value)) {
            foreach ($name as $key => $val) {
                $this->curl_config[$key] = $val;
            }
        } else {
            $this->curl_config[$name] = $value;
        }

        return $this;
    }

    private function useragent()
    {
        $s = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36',
        ];
        shuffle($s);

        return $s[0];
    }

    private function microtime_float()
    {
        list($usec, $sec) = explode(' ', microtime());

        return ((float)$usec + (float)$sec);
    }
}