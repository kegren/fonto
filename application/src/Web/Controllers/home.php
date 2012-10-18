<?php
/**
 * Homepage controller
 */

namespace Web\Controllers;

use Fonto\Core\Controller;

class Home extends Controller
{
	public function indexAction()
	{
		$data = array(
			'title' => 'Fonto PHP Framework',
			'text'  => 'Under development!'
		);

		return $this->view('home/index', $data);
	}
}