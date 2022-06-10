<?php namespace App\Commands\Control;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateMethod extends BaseCommand
{
    protected $group       = 'Control';
    protected $name        = 'control:createMethod';
    protected $description = 'Создаём новый метод или его следующую версию. Аргумент - блок.метод';

    public function run(array $params)
    {
        if (empty($params[0]))
        {
            CLI::write('Необходимо передать название метода', 'red');
            return false;
        }
        helper('filesystem');
        $explode = explode('.', $params[0]);
        $block   = ucfirst($explode[0]);
        $method  = ucfirst($explode[1]);

        $examples = [
            'method'               => file_get_contents(WRITEPATH . 'examples/method.example'),
        ];

        foreach ($examples as $k => $row)
        {
            $examples[$k] = str_replace(['{{BLOCK}}', '{{METHOD}}'], [$block, $method], $row);
        }
        $directory = APPPATH . 'Api/';

        if (! is_dir($directory . $block))
        {
            mkdir($directory . $block, 0775);
        }

        if (! is_dir($directory . $block . '/' . $method))
        {
            mkdir($directory . $block . '/' . $method, 0775);
        }

        $verions      = directory_map($directory . $block . '/' . $method );
        $version      = [
            'minor' => 1,
            'major' => -1,
        ];
        $data_version = [];
        foreach ($verions as $row)
        {
            preg_match('#V(.*)_(.*)\.php#Us', $row, $versions);
            $data_version[(int)$versions[1]][] = (int)$versions[2];
        }
        ksort($data_version);
        foreach ($data_version as $k => $row)
        {
            $version['minor'] = $k;
            asort($row);
            foreach ($row as $row2)
            {
                $version['major'] = $row2;
            }
        }
        $version['major']++;
        $v = $version['minor'] . '_' . $version['major'];

        $examples['method'] = str_replace('{{VERSION}}', $v, $examples['method']);
        file_put_contents($directory . $block . '/' . $method . '/V' . $v . '.php', $examples['method'], 0755);

        CLI::write('Создана версия ' . $version['minor'] . '.' . $version['major'] . ' - ' . $block . '.' . $method . '', 'green');
    }

}
