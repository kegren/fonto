<?php
/**
 * Homepage controller
 */

namespace Demo\Controller;

use Fonto\Core\Controller\Base;

class Home extends Base
{
    public function before()
    {
        echo "Before anything else!";
    }

    public function __construct()
    {
        //parent::__construct();

        $this->filter(array('index', 'test'), function() {
            echo 'filtered!';
        });
    }

	public function getIndexAction()
	{
        echo $this->value;

        $dimanager = new \Fonto\Core\DI\DIManager();
        //

        die;


        $type = 'mysql';
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $name = 'fontomvc';

        $dsn = "$type://$user:$pass@$host/$name";

        \ActiveRecord\Config::initialize(
            function ($cfg) use ($dsn) {
                $cfg->set_model_directory(MODELPATH);
                $cfg->set_connections(
                    array(
                        'development' => $dsn
                    )
                );
            }
        );

        $user = new \Demo\Model\User();

        _pr(\Demo\Model\User::find_by_id(1));


        die;
        $val = $this['di']->getService('validator');

        $rule = new \Demo\Model\Form\Example();
        $rules = $rule->rules();

        $data = array(
            'username' => 'kenddddd',
            'password' => 'fosk'
        );

        $val->validate($rules, $data);

        echo $val->isValid();

        $url = $this->url();

        //$user = new \Demo\Model\User();

        //_pr(\Demo\Model\User::find_by_id(1));

		$data = array(
			'title'   => 'Fonto PHP Framework',
			'text'    => 'Under development',
			'version' => '',
			'baseUrl' => $url->baseUrl(),
		);

		return $this->view()->render('home/index', $data);
	}

    public function testAction()
    {
        echo "hej";
    }


}