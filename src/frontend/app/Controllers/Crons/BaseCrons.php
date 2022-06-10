<?php namespace App\Controllers\Crons;

use CodeIgniter\Controller;
use Config\Sentry;
use Config\Database;
use Config\Services;

class BaseCrons extends Controller
{

    protected $helpers = ['general'];

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->sentry = Sentry::init();

        $this->db    = Database::connect();
        $this->cache = Services::cache();
    }

}
