<?php namespace Config;

class Sentry
{
    public static function init()
    {
        return \Sentry\init(['dsn' => 'https://209bd5b54f404b5390b5f391c41a41ba@getsentry.rave.dev/28']);
    }
}


