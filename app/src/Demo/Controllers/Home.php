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
		$url = $this->url(); // Short
		$form = $this->form();

		$session = $this->app->container['session'];
		$session->set('username', 'fonto');

		$data = array(
			'title'   => 'Fonto PHP Framework',
			'text'    => 'Under development!',
			'baseUrl' => $url->baseUrl(),
			'session' => $session,
			'form'    => $form
		);

		$view = $this->app->container['view'];
		$view->render('home/index', $data);
	}
}