<?php
/**
 * Homepage controller
 */

namespace Demo\Controller;

use Fonto\Core\Controller\Base;

class Home extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getIndexAction()
	{
		$data = array(
			'title'   => 'Fonto PHP Framework',
			'text'    => 'Under development',
			'baseUrl' => $this->url()->baseUrl()
		);

        return $this->view()->render('home/index', $data);
	}
}