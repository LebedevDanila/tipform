<?php namespace App\Controllers;

use Config\Services;
use Tholu\Packer\Packer;

class Bundles extends BaseController
{

    /**
     * @param string $page
     */
    public function js($page = '')
    {
        $cache = Services::cache();
        $this->response->setHeader('Pragma','cache');
        $this->response->setHeader('Cache-Control', 'max-age=604800');
        $this->response->setHeader('Content-Type','application/javascript');
        if ($page === 'main-min')
        {
            if (! $cache->get('view.bundle.js.' . md5($page)) || env('app.env') === 'dev')
            {
                $resp = file_get_contents(ROOTPATH.'public/static/js/main-min.js');

                $cache->save('view.bundle.js.' . md5($page), $resp, 120);
            }
        }

        $resp = $cache->get('view.bundle.js.' . md5($page));
        $this->response->setContentType('application/javascript');
        return $resp;
    }

    public function css($page = '')
    {
        $cache = Services::cache();
        $this->response->setHeader('Pragma','cache');
        $this->response->setHeader('Cache-Control', 'max-age=604800');
        $this->response->setHeader('Content-Type','text/css');
        if ($page === 'main-min')
        {
            if (! $cache->get('view.bundle.css.' . md5($page)))
            {
                $resp = file_get_contents(ROOTPATH . 'public/static/css/main.css');
                $cache->save('view.bundle.css.' . md5($page), $resp, 120);
            }
        }
        if ($page === 'bvi')
        {
            if (! $cache->get('view.bundle.css.' . md5($page)))
            {
                $resp = file_get_contents(APPPATH . '/Views/blocks/jqueryUi/css/bvi.scss');
                $cache->save('view.bundle.css.' . md5($page), $resp, 120);
            }
        }

        $resp = $cache->get('view.bundle.css.' . md5($page));

        $this->response->setContentType('text/css');
        return $resp;
    }

    public function js_lib($lib = '')
    {
        $this->response->setHeader('Pragma','cache');
        $this->response->setHeader('Cache-Control', 'max-age=604800');
        $this->response->setHeader('Content-Type','application/javascript');

        $resp      = file_get_contents(APPPATH . '/Views/modules/librariesJs/' . $lib . '.js');
        $packer    = new Packer($resp, 'Normal', false, false, false);
        $packed_js = $packer->pack();

        $this->response->setContentType('application/javascript');
        return $packed_js;
    }
}
