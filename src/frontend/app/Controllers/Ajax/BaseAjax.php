<?php
namespace App\Controllers\Ajax;

use App\Libraries\Utils\Output;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Config\Exceptions;
use Config\Sentry;
use Config\Services;
use Psr\Log\LoggerInterface;

class BaseAjax extends Controller
{
    protected $helpers = ['general'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->sentry = Sentry::init();

        if ( ! empty($_SERVER['HOSTNAME'])) {
            $this->response->setHeader('Server-ID', $_SERVER['HOSTNAME']);
        }

        $this->output  = new Output();
        $this->session = Services::session();
        $this->db      = Database::connect();

        $headers = $request->getHeaders();
        if (empty($headers['X-' . env('protection.name') . '-Refe'])) {
            die($this->output->responseError(400));
        }

        $url            = parse_url($headers['X-' . env('protection.name') . '-Refe']->getValue());
        $this->url_path = (empty($url['path']) ? '/' : $url['path']);

        $segments = $request->uri->getSegments();
        if ($segments[1] !== 'protection' && $segments[2] !== 'init') {
            $csrf = $headers['X-' . env('protection.name') . '-Csrf']->getValue();

            if (empty($csrf)) {
                die($this->output->responseError(419));
            }
            $ex         = explode('-', $csrf);
            $protected  = ($this->session->get('protect') ? $this->session->get('protect') : []);
            $b64        = base64_encode($this->url_path);
            $is_protect = false;
            foreach ($protected as $row) {
                if ($row['h'] === $ex[1] && (double)$row['t'] === (double)$ex[0] && $row['p'] === $b64) {
                    $is_protect = true;
                }
            }
            if ($is_protect === false) {
                die($this->output->responseError(419));
            }
        }

        $this->response->setContentType('application/json');
    }
}
