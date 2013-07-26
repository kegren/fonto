<?php
/**
 * Home controller
 */

namespace Demo\Controller;

use Fonto\Controller\Base;

class Home extends Base
{
    public $restful = true;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = array(
            'title' => 'Fonto PHP Framework',
            'text' => 'Under development',
            'baseUrl' => $this->url()->baseUrl(),
        );

        return $this->view()->render('home/index', $data);
    }
}
