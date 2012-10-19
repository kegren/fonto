<?php
/**
 * Homepage controller
 */

namespace Web\Controllers;

use Fonto\Core\Controller,
	Fonto\Core\Url;

class Home extends Controller
{
	public function indexAction()
	{
		$url = new Url();

		$data = array(
			'title'   => 'Fonto PHP Framework',
			'text'    => 'Under development!',
			'baseUrl' => $url->baseUrl()
		);

		return $this->view('home/index', $data);
	}
}