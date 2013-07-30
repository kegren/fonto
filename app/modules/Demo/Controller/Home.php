<?php
/**
 * Home controller
 */

namespace Demo\Controller;

use Fonto\Controller\Base;
use Fonto\Facade\Url;
use Fonto\Facade\View;

class Home extends Base
{
    public $restful = true;

    /**
     * @return mixed
     */
    public function index()
    {
        $data = array(
            'title' => 'Fonto',
            'baseUrl' => Url::baseUrl(),
        );

        return View::render('home/index', $data, "demo");
    }
}
