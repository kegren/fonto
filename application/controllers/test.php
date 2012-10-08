<?php

namespace Application\Controllers;

use \Fonto\Core\IController;

class Test implements IController
{
	public function indexAction()
	{
		echo 'Test';
	}
}