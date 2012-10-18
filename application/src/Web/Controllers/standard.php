<?php

namespace Web\Controllers;

use Fonto\Core\Controller;

class Standard extends Controller
{
	public function indexAction()
	{
		echo 'Test';
	}

	public function updateAction($name = 10)
	{
		echo $name;
	}
}