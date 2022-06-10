<?php namespace App\Commands\Frontend;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateBlock extends BaseCommand
{
    protected $group       = 'Frontend';
    protected $name        = 'frontent:createBlock';
    protected $description = 'Создать новый блок. Аргумент - название';

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

        if (is_dir($directory))
        {
            CLI::write('Блок уже существует', 'red');
            return false;
        }
        $directory_css = $directory . '/css';
        $directory_js  = $directory . '/js';
        $directory_img = $directory . '/img';
        mkdir($directory, 0775);
        mkdir($directory_css, 0775);
        mkdir($directory_js, 0775);
        mkdir($directory_img, 0775);

        file_put_contents($directory . '/' . $name . '.php', '', 0755);
        file_put_contents($directory_css . '/' . $name . '.scss', "\$img_this: '/static/img/blocks/$name/';", 0755);
        file_put_contents($directory_css . '/' . $name . '_mobile.scss', "@import \"{$name}\";", 0755);
        file_put_contents($directory_js . '/' . $name . '.js', '', 0755);

        $css = file_get_contents($directory_include_css) . "//start-block--$name\n@import \"../../blocks/$name/css/{$name}_mobile\";\n//stop-block--$name\n";
        file_put_contents($directory_include_css, $css);

        CLI::write('Блок ' . $name . ' создан!', 'green');
    }
}
