<?php namespace App\Controllers;

use App\Libraries\Utils\Output;
use CodeIgniter\Controller;
use \App\Libraries\Services\IpApi;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Config\Sentry;
use Config\Services;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{

	protected $helpers = [
		'view',
		'general',
	];

	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);

        $this->sentry = Sentry::init();
		if(!empty($_SERVER['HOSTNAME']))
        {
            $this->response->setHeader('Server-ID', $_SERVER['HOSTNAME']);
        }

		$this->output  = new Output();
		$this->session = Services::session();
		$this->db      = Database::connect();
		$this->cache   = Services::cache();

		$this->data                 = [];
		$this->view_file            = 'index';
		$this->response->view_files = [
			'pages'  => [],
			'blocks' => [],
		];



		/*$fragments = [];
		if ($this->request->getHeaderLine('X-PJAX-Container'))
		{
			$ex = explode(',', $this->request->getHeaderLine('X-PJAX-Container'));
			foreach ($ex as $row)
			{
				$row = trim($row);
				if (empty($row))
				{
					continue;
				}
				$fragments[] = substr($row, 1, -1);
			}
		}*/

        $useragent = $this->request->getUserAgent();

		$this->data = [
			'pjax' => [
				'status'    => 0,
				'fragments' => [],
			],
			'meta' => [
				'title'       => '',
				'description' => '',
				'keywords'    => '',
				'robot'       => 1,
				'canonical'   => false,
                'og'          => [
                    'site_name' => env('app.baseURL'),
                    'type'      => 'website',
                    'image'     => '',
                    'url'       => env('app.baseURL') . '/' . $request->uri->getPath(),
                ],
			],
            'search' => [
                'title' => "",
                'descr' => ""
            ],
			'useragent' => $useragent,
		];
	}
}
