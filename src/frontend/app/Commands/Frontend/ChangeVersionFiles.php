<?php namespace App\Commands\Frontend;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ChangeVersionFiles extends BaseCommand
{
	protected $group       = 'Frontend';
	protected $name        = 'frontent:changeVersionFiles';
	protected $description = 'Изменяет версию файлов на последнюю';

	public function run(array $params)
	{
		helper('filesystem');
        
        $microtime = microtime();
        
		$js  = md5($microtime.mt_rand(1000,9999));
		$css = md5($microtime.mt_rand(1000,9999));

		$version_js  = $js;
		$version_css = $css;

		$file = file_get_contents(APPPATH.'/Config/Constants.php');

		$file = preg_replace("/define\('FRONTEND_VERSION_CSS', '(.*)'\)/Us", "define('FRONTEND_VERSION_CSS', '" . $version_css . "')", $file);
		$file = preg_replace("/define\('FRONTEND_VERSION_JS', '(.*)'\)/Us", "define('FRONTEND_VERSION_JS', '" . $version_js . "')", $file);
		file_put_contents(APPPATH.'/Config/Constants.php', $file);

		CLI::write('Ok', 'green');
	}

	private function rrmdir($src)
	{
	}
}
