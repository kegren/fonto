<?php

namespace Application\Controllers;

use \Fonto\Core\IController,
	\Fonto\Core\View;

class Home implements IController
{
	public function indexAction()
	{
		$data = array(
			'test' => '568t'
		);

		return View::show('home/index', $data);
	}
}