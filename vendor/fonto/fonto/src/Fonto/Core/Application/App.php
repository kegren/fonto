<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Application;

use Fonto\Core\Router;
use	Fonto\Core\Request;
use	Fonto\Core\DI\Container;
use Fonto\Core\Config;

class App
{
	/**
	 * Current version
	 */
	const VERSION = '0.3-DEV';

	/**
	 * Default timezone
	 */
	const DEFAULT_TIMEZONE = 'Europe/Stockholm';

	/**
	 * \Fonto\Core\Application\App
	 *
	 * @var object
	 */
	public $app;

	/**
	 * \Fonto\Core\DI\Container
	 *
	 * @var object
	 */
	private $container;

	/**
	 * \Fonto\Core\Request
	 *
	 * @var object
	 */
	private $request;

	/**
	 * \Fonto\Core\Controller
	 *
	 * @var object
	 */
	private $controller;

	/**
	 * Storage for all routes
	 *
	 * @var array
	 */
	private $routes = array();

	/**
	 * Environment for the application
	 *
	 * @var string
	 */
	private $environment;

	protected $name = 'Web';

	public function __construct()
	{
		//Setup application
		$app = $this;

		$this->registerAutoload();

		$this->container = new Container();
		$this->container['router'] = function() use ($app) {
			return new Router($app->getRoutes(), $app->getRequest());
		};

		$this->container['config'] = function() use ($app){
			return new Config\Base($app, array(CONFIGPATH, APPPATH));
		};
	}

	public function setup()
	{
		$config = $this->container['config'];
		$config->load('routes', 'routes');

		$env = $config->load('app', 'environment');
		$this->setEnvironment($env);

		$timezone = $config->load('app', 'timezone');
		$this->setTimezone($timezone);

		// $this->container->build('\Fonto\Core\Config\Base', $app, array('1'))->load('aik');

		$this->setExceptionHandler(array('Fonto\Core\FontoException', 'handle'));
		return $this;
	}



	/**
	 * Run app
	 */
	public function run()
	{
		try {
			$matched = $this->container['router']->match();

			if (false === $matched) {
				throw new \Fonto\Core\FontoException("No route was found");
			}

			$route = $matched->run();

		} catch (FontoException $e) {
			throw $e;
		}
	}

	/**
	 * Current version
	 *
	 * @return string
	 */
	public function version()
	{
		return self::VERSION;
	}

	/**
	 * Add routes
	 *
	 * @param  string $route
	 * @param  string $uses
	 * @return object
	 */
	public function addRoute($route, $uses)
    {
        $this->routes[$route]  = $uses;

        return $this;
    }

    /**
     * Load ActiveRecords and set directory for models
     *
     * @todo   Fix hardcoded database settings (cant use $this ref?)
     * @return void
     */
    public function setActiveRecord($active = true)
    {
    	if (false === $active) {
    		return;
    	}

    	$config = $this->container->get('config')->load('app', 'database');
    	if ($config === false) {
    		throw new Exception("Missing database settings from application config file");
    	}
    	$type = $config['type'];
    	$host = $config['host'];
    	$user = $config['user'];
    	$pass = $config['pass'];
    	$name = $config['name'];

    	$dsn = "$type://$user:$pass@$host/$name";
     	\ActiveRecord\Config::initialize(function($cfg) use($dsn)
		{
     		$cfg->set_model_directory(MODELPATH);
	    	$cfg->set_connections(array(
	    	'development' => $dsn));
 		});

 		return $this;
    }

    public function setTwig($active = true)
    {
    	if (false === $active) {
    		return;
    	}

    	return $this;
    }

    public function getRequest()
    {
    	return new Request();
    }

    /**
	 * Get all registered routes
	 *
	 * @return array
	 */
    public function getRoutes()
    {
    	return (array) $this->routes;
    }

    /**
     * Register composers autoloader and add
     * namespace for application
     *
     * @return void
     */
	private function registerAutoload($ns = null)
	{
		$loader = include VENDORPATH . 'autoload' . EXT;
		if (null === $ns) {
			$loader->add($this->name, APPPATH . 'src');
		} else {
			$loader->add($ns, APPPATH . 'src');
		}

		return $this;
	}

	public function setAppName($name = null)
	{
		if (null === $name) {
			$this->name = 'Web';
		} else {
			$this->name = $name;
		}

		return $this;
	}

	/**
	 * Get container
	 *
	 * @return object
	 */
	private function getContainer()
	{
		return $this->container;
	}

	/**
	 * Set error_reporting
	 */
	private function setErrorReporting()
	{
		$env = $this->getEnvironment();

		switch ($env) {
			case 'development':
				error_reporting(-1);
				break;

			case 'production':
				error_reporting(0);
				break;

			default:
				throw new FontoException("$env most be either 'development' or 'production'");
				break;
		}
	}

	/**
	 * Get environment
	 *
	 * @return string
	 */
	private function getEnvironment()
	{
		return $this->environment;
	}

	/**
	 * Set environment for application
	 *
	 * @param string $env
	 */
	private function setEnvironment($env = null)
	{
		if (null === $env) {
			$this->environment = 'development';
		} else {
			$this->environment = $env;
		}
		return $this;
	}

	/**
	 * Setting custom exception handler
	 *
	 * @param array $options
	 */
	private function setExceptionHandler(array $options = array())
	{
		set_exception_handler($options);
	}

	/**
	 * Set default timezone
	 *
	 * @param string $value
	 */
	private function setTimezone($value = null)
	{
		if (null === $value) {
			date_default_timezone_set(self::DEFAULT_TIMEZONE);
		} else {
			date_default_timezone_set($value);
		}
		return $this;
	}
}