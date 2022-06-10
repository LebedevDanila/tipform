<?php namespace App\Libraries\Utils;

use Exception;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;


class Cdn
{
    public function __construct()
    {
        $client = new S3Client([
            'credentials' => [
                'key'    => '8400106bf9ab463ea2be7166931f4c4b',
                'secret' => '79901bc7dc7e435c9554d9823bcdcfc8'
            ],
            'region' => 'waw',
            'version' => 'latest',
            "endpoint"  =>'https://s3.waw.cloud.ovh.net',
        ]);

        $adapter = new AwsS3V3Adapter($client, 'cdn-instaprofi-ru');

        $this->filesystem = new Filesystem($adapter);
    }

    public function get($name = '')
    {
        try
        {
            $resp = $this->filesystem->read($name);
            return $resp;
        }
        catch (Exception $ex)
        {
            return '';
        }
    }

    public function put($name = '', $data = '')
    {
        return $this->filesystem->write($name, $data, []);
    }

    public function delete($name = '')
    {
        return $this->filesystem->delete($name);
    }

    public function deleteDir($name = '')
    {
        return $this->filesystem->deleteDirectory($name);
    }

    public function check($name = '')
    {
        return $this->filesystem->fileExists($name);
    }
}
