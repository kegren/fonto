<?php

namespace Web\Controllers;

use Fonto\Core\Controller;

class Home extends Controller
{
	public function indexAction()
	{
		$data = array(
			'test' => '568t'
		);

		return $this->view('home/index', $data);
	}
}