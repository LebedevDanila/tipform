<?php

define('FC_PATH', __DIR__ . DIRECTORY_SEPARATOR);
if(file_exists(FC_PATH . '.env'))
{
    $data = file_get_contents(FC_PATH . '.env');
    if(! empty($data))
    {
        exit;
    }

}
file_put_contents(FC_PATH . '.env', $_ENV['CONFIG_MAP'], 0777);
exit;