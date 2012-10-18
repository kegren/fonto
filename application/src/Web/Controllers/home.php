<?php
/**
 * Homepage controller
 *
 */

namespace Web\Controllers;

use Fonto\Core\Controller;

class Home extends Controller
{
	public function indexAction()
	{
		$data = array(
			'title' => 'Title',
			'text' => 'Some text'
		);

		return $this->view('home/index', $data);
	}
}