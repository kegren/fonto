<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Application;

//require 'Base.php';

use Fonto\Core\Routing\Router;
use Fonto\Core\FontoException;
use ActiveRecord;
use Hautelook\Phpass\PasswordHash;
use HTMLPurifier as Purifier;

class App extends Base
{
	/**
	 * Fonto\Core\Application\App
	 *
	 * @var object
	 */
	public $app;

	/**
	 * Fonto\Core\Controller
	 *
	 * @var object
	 */
	protected $controller;

	public function __construct()
	{
        parent::__construct(appOptions());

        $this->app = $this;

        $this->connectActiveRecords();
        $this->setExceptionHandler(array('\Fonto\Core\FontoException', 'handle'));
	}

	/**
	 * Runs the application.
	 */
	public function run($autoloader)
	{
		try {
            $autoloader->add($this->getActiveApp(), APPPATH . 'src');
			$router = $this->getDi()->getService('router');

			$matched = $router->match();

			if (false === $matched) {
				throw new FontoException("No route was found");
			}

			$route = $matched->dispatch();

		} catch (FontoException $e) {
			throw $e;
		}
	}

    protected function getApp()
    {
        return $this;
    }

    /**
     * Loads ActiveRecords and sets directory for models
     *
     * @throws Exception
     * @return Application
     */
    private function connectActiveRecords()
    {
        if ($this->getEnv() == 'local') {
            $config = $this->getDbLocal();
        } else {
            $config = $this->getDbServer();
        }

    	$type = $config['type'];
    	$host = $config['host'];
    	$user = $config['user'];
    	$pass = $config['pass'];
    	$name = $config['name'];

    	$dsn = "$type://$user:$pass@$host/$name";

     	ActiveRecord\Config::initialize(function($cfg) use($dsn)
		{
     		$cfg->set_model_directory(MODELPATH);
	    	$cfg->set_connections(array(
	    	'development' => $dsn));
 		});

 		return $this;
    }

	/**
	 * Sets custom exception handler
	 *
	 * @param array $options
	 */
	private function setExceptionHandler(array $options = array())
	{
		set_exception_handler($options);
	}
}