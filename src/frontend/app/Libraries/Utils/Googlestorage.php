<?php namespace App\Libraries\Utils;

use Exception;
use Google\Cloud\Storage\StorageClient;

class Googlestorage
{
    public function __construct()
    {
        $this->storage = new StorageClient([
            'projectId'   => 'reestrgov-ru',
            'keyFilePath' => APPPATH . 'Config/GoogleKeys/reestrgov-storage.json',
        ]);
        $this->bucket  = $this->storage->bucket('reestrgov-ru');
    }

    public function get($name = '')
    {
        try
        {
            $object = $this->bucket->object($name);
            return $object->downloadAsString();
        }
        catch (Exception $ex)
        {
            return '';
        }
    }

    public function put($name = '', $data = '')
    {
        return $this->bucket->upload($data, ['name' => $name, 'predefinedAcl' => 'publicRead']);
    }

    public function delete($name = '')
    {
        return $this->bucket->object($name)->delete();
    }

    public function check($name = '')
    {
        return $this->bucket->object($name)->exists();
    }
}
