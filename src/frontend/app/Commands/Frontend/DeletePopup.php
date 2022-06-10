<?php namespace App\Commands\Frontend;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DeletePopup extends BaseCommand
{
    protected $group       = 'Frontend';
    protected $name        = 'frontent:deletePopup';
    protected $description = 'Удалить popup. Аргумент - название';

    public function run(array $params)
    {
        if (empty($params[0]))
        {
            CLI::write('Введи название popup через пробел', 'red');
            return false;
        }
        $name      = $params[0];
        $directory = APPPATH . 'Views/popups/' . $name;

        $directory_include_css = APPPATH . '/Views/modules/includeCss/includePopups.scss';
        $directory_include_js  = APPPATH . '/Views/modules/includeJs/include.txt';

        if (! is_dir($directory))
        {
            CLI::write('Popup не существует', 'red');
            return false;
        }
        $this->rrmdir($directory);

        $css = file_get_contents($directory_include_css);
        $css = preg_replace('#\/\/start-popup--' . $name . '.*\/\/stop-popup--' . $name . "\n#Us", '', $css);
        file_put_contents($directory_include_css, $css);

        CLI::write('Popup ' . $name . ' удалён!', 'green');
    }

    private function rrmdir($src)
    {
        $dir = opendir($src);
        while (false !== ( $file = readdir($dir)))
        {
            if (( $file !== '.' ) && ( $file !== '..' ))
            {
                $full = $src . '/' . $file;
                if (is_dir($full))
                {
                    $this->rrmdir($full);
                }
                else
                {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($src);
    }
}
