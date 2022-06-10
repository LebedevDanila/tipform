<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Config\Sentry;
use Psr\Log\LoggerInterface;

class Healthcheck extends Controller
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->sentry = Sentry::init();
    }

    public function check()
    {
        $this->db        = Database::connect();
        $this->db->connect();

        return 'OK';
    }
}