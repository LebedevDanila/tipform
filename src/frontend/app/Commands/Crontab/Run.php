<?php namespace App\Commands\Crontab;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use \GO\Scheduler;

class Run extends BaseCommand
{
    protected $group       = 'Crontab';
    protected $name        = 'crontab:run';
    protected $description = 'Запускаем каждую минуту php spark crontab:schedul * * * * *';

    public function run(array $params)
    {
        $scheduler  = new Scheduler();
        $string     = "php ".ROOTPATH."public/index.php ";

        //$scheduler->raw($string.'crons instagram autoparser')->at('*/5 * * * *');

        $resp = $scheduler->run();

        foreach($resp as $row)
        {
            CLI::write($row->compile(), 'yellow');
        }
        CLI::write('Crontab Success', 'green');
    }

}
