<?php namespace App\Libraries;

use \App\Api\Output;

class Api
{
    /**
     *
     * @param string $method
     * @param array $data
     * @param string $version
     * @return array|bool
     */
    public function call($method = "", $data = [], $version = "1.0")
    {
        $version        = str_replace('.', '_', $version);
        $method_data    = explode(".", $method);
        if(count($method_data) != 2)
        {
            return false;
        }
        $block   = ucfirst($method_data[0]);
        $method  = ucfirst($method_data[1]);
        $namespace = "App\Api\\".$block."\\".$method."\\" . "V" . $version;

        if (method_exists($namespace, 'execute') === false)
        {
            return (new Output())->error(12, $data);
        }
        else
        {
            return (new $namespace)->execute($data);
        }
    }

}
