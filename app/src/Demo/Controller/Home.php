<?php
/**
 * Homepage controller
 */

namespace Demo\Controllers;

use Fonto\Core\Controller\Base;

class Home extends Base
{
	public function indexAction()
	{
		$url = $this->url();

		$data = array(
			'title'   => 'Fonto PHP Framework',
			'text'    => 'Under development',
			'version' => $this->app->version(),
			'baseUrl' => $url->baseUrl(),
		);

		return $this->view()->render('home/index', $data);
	}
}