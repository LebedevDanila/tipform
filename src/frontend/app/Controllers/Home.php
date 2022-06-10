<?php

namespace App\Controllers;

use \App\Libraries\Api;

class Home extends BaseController {

	public function index()
	{
		$this->data['content']             = 'main';
		$this->data['meta']['title']       = 'Главная';
		$this->data['meta']['description'] = '';
		$this->data['meta']['keywords']    = '';

        $this->data['meta']['og']['title']       = $this->data['meta']['title'];
        $this->data['meta']['og']['description'] = $this->data['meta']['description'];
        $this->data['meta']['og']['keywords']    = $this->data['meta']['keywords'];

		if ( ! empty($_GET))
		{
			$this->data['meta']['canonical'] = env('app.baseURL') . '/';
		}

		$view_main = view_main($this->view_file, $this->data);
		return $view_main;
	}


}
