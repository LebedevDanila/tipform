<?php namespace App\Commands\Frontend;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DeleteBlock extends BaseCommand
{
    protected $group       = 'Frontend';
    protected $name        = 'frontent:deleteBlock';
    protected $description = 'Удалить блок. Аргумент - название';

    public function run(array $params)
    {
        if (empty($params[0]))
        {
            CLI::write('Введи название блока через пробел', 'red');
            return false;
        }
        $name      = $params[0];
        $directory = APPPATH . 'Views/blocks/' . $name;

        $directory_include_css = APPPATH . '/Views/modules/includeCss/includeBlocks.scss';
        $directory_include_js  = APPPATH . '/Views/modules/includeJs/include.txt';

        if (! is_dir($directory))
        {
            CLI::write('Блок не существует', 'red');
            return false;
        }
        $this->rrmdir($directory);

        $css = file_get_contents($directory_include_css);
        $css = preg_replace('#\/\/start-block--' . $name . '.*\/\/stop-block--' . $name . "\n#Us", '', $css);
        file_put_contents($directory_include_css, $css);

        CLI::write('Блок ' . $name . ' удалён!', 'green');
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
