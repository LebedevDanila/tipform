<?php namespace App\Controllers\Ajax;

class Protection extends BaseAjax
{
	public function init()
	{
		$time = round(microtime_float(), 4);
		$path = base64_encode($this->url_path);
		$hash = generateHash(24, ':');

		$protect = $this->session->get('protect');
		if (empty($protect))
		{
			$protect = [];
		}
		$protect = array_reverse($protect);
		foreach ($protect as $k => $row)
		{
			if ($k > 10)
			{
				unset($protect[$k]);
			}
		}
		$protect   = array_reverse($protect);
		$protect[] = [
			'p' => $path,
			'h' => $hash,
			't' => $time,
		];
		$this->session->set('protect', $protect);
		return $this->output->responseSuccess(['hash' => $hash, 'time' => $time]);
	}
}
