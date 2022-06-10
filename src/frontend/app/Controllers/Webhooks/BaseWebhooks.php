<?php namespace App\Controllers\Webhooks;

use CodeIgniter\Controller;
use CodeIgniter\CLI\CLI;

class BaseWebhooks extends Controller{

    protected $helpers = [
        'general',
    ];

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        helper('general');

        $request  = \Config\Services::request();
        $segments = $request->uri->getSegments();
        if (empty($segments[3]) || $segments[3] !== 'f1aw52h0')
        {
            die('Error request Webhook');
        }

        $this->db = \Config\Database::connect();
    }
}
