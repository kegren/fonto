<?php
/**
 * Homepage controller
 */

namespace Demo\Controllers;

use Fonto\Core\Controller;

class Home extends Controller
{
	public function indexAction()
	{
		$url = $this->app->container['url'];

		$data = array(
			'title'   => 'Fonto PHP Framework',
			'text'    => 'Under development!',
			'baseUrl' => $url->baseUrl()
		);

		$view = $this->app->container['view'];
		$view->render('home/index', $data);
	}
}