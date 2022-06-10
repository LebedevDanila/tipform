<?php namespace App\Commands\Frontend;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CollectPictures extends BaseCommand
{
	protected $group       = 'Frontend';
	protected $name        = 'frontent:collectPictures';
	protected $description = 'Собирает картинки из внутренних папок во внешнюю';

	public function run(array $params)
	{
		helper('filesystem');

		if (is_dir(FCPATH.'static' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR))
		{
			$this->rrmdir(FCPATH.'static' . DIRECTORY_SEPARATOR . 'img');
		}
		mkdir(FCPATH.'static' . DIRECTORY_SEPARATOR . 'img', 0755);
		mkdir(FCPATH.'static' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'blocks', 0755);
		mkdir(FCPATH.'static' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'pages', 0755);
		mkdir(FCPATH.'static' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'popups', 0755);

		$map = directory_map(APPPATH . 'Views' . DIRECTORY_SEPARATOR . 'blocks');
		foreach ($map as $module_name => $modules)
		{
			foreach ($modules as $path_name => $row)
			{
				if (! is_array($row))
				{
					continue;
				}

				if ($path_name === 'img' . DIRECTORY_SEPARATOR && ! empty($row))
				{
					mkdir(FCPATH.'static' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'blocks' . DIRECTORY_SEPARATOR . $module_name, 0755);
					foreach ($row as $img)
					{
						copy(APPPATH . 'Views' . DIRECTORY_SEPARATOR . 'blocks' . DIRECTORY_SEPARATOR . $module_name . 'img' . DIRECTORY_SEPARATOR . $img, FCPATH.'static' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'blocks' . DIRECTORY_SEPARATOR . $module_name .  DIRECTORY_SEPARATOR . $img);
					}
				}
			}
		}

		$map = directory_map(APPPATH . 'Views' . DIRECTORY_SEPARATOR . 'pages');
		foreach ($map as $module_name => $modules)
		{
			foreach ($modules as $path_name => $row)
			{
				if (! is_array($row))
				{
					continue;
				}
				if ($path_name === 'img' . DIRECTORY_SEPARATOR && ! empty($row))
				{
					mkdir(FCPATH.'static' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $module_name, 0755);
					foreach ($row as $img)
					{
                        copy(APPPATH . 'Views' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $module_name . 'img' . DIRECTORY_SEPARATOR . $img, FCPATH.'static' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $module_name .  DIRECTORY_SEPARATOR . $img);
					}
				}
			}
		}

		$map = directory_map(APPPATH . 'Views' . DIRECTORY_SEPARATOR . 'popups');
		foreach ($map as $module_name => $modules)
		{
			foreach ($modules as $path_name => $row)
			{
				if (! is_array($row))
				{
					continue;
				}
				if ($path_name === 'img' . DIRECTORY_SEPARATOR && ! empty($row))
				{
					mkdir(FCPATH.'static' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'popups' . DIRECTORY_SEPARATOR . $module_name, 0755);
					foreach ($row as $img)
					{
                        copy(APPPATH . 'Views' . DIRECTORY_SEPARATOR . 'popups' . DIRECTORY_SEPARATOR . $module_name . 'img' . DIRECTORY_SEPARATOR . $img, FCPATH.'static' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'popups' . DIRECTORY_SEPARATOR . $module_name .  DIRECTORY_SEPARATOR . $img);
					}
				}
			}
		}

		CLI::write('Картинки выгружены', 'green');
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
