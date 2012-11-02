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
use Fonto\Core\FontoException;
use Fonto\Core\Controller;
use Fonto\Core\Url;
use Fonto\Core\View;

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
	 * Fonto\Core\Application\App
	 *
	 * @var object
	 */
	public $app;

	/**
	 * Fonto\Core\DI\Container
	 *
	 * @var object
	 */
	public $container;

	/**
	 * Fonto\Core\Controller
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

	/**
	 *
	 *
	 * @var [type]
	 */
	private $twigEnabled;


	/**
	 * Name for the app
	 *
	 * @var string
	 */
	protected $appName;

	public function __construct($name = null)
	{
		if (null === $name) {
			$this->appName = 'demo';
		} else {
			$this->appName = $name;
		}

		$this->registerAutoload();
	}

	public function setup()
	{
		$app = $this;

		$this->container = new Container($app);

		$this->container['router'] = function() use ($app) {
			$router = new Router();
			$router->setApp($app);

			return $router;
		};

		$this->container['controller'] = function() use ($app) {
			$controller = new Controller();
			$controller->setApp($app);

			return $controller;
		};

		$this->container['request'] = function() {
			return new Request();
		};

		$this->container['config'] = function() use ($app) {
			return new Config\Base($app, array(CONFIGPATH, APPPATH));
		};

		$this->container['url'] = function() {
			return new Url();
		};

		$this->container['view'] = function() use ($app) {
			$view = new View();
			$view->setApp($app);

			return $view;
		};

		$this->container['twig'] = function() {
			$loader = new \Twig_Loader_Filesystem(VIEWPATH);
      		$twig = new \Twig_Environment($loader);

      		return $twig;
		};

		$config = $this->container['config'];
		$config->load('routes', 'routes');

		$env = $config->load('app', 'environment');
		$this->setEnvironment($env);

		$timezone = $config->load('app', 'timezone');
		$this->setTimezone($timezone);

		$this->setExceptionHandler(array('Fonto\Core\FontoException', 'handle'));

		return $this;
	}

	/**
	 * Run app
	 */
	public function run()
	{
		try {
			$router = $this->container['router'];
			$router->setRoutes($this->routes);

			$matched = $router->match($this->routes);

			if (false === $matched) {
				throw new FontoException("No route was found");
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

    public function useTwig($active)
    {
    	$this->twigEnabled = $active;

    	return $this;
    }

    public function isTwig()
    {
    	return $this->twigEnabled;
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
			$loader->add($this->appName, APPPATH . 'src');
		} else {
			$loader->add($ns, APPPATH . 'src');
		}

		return $this;
	}

	public function setAppName($name = null)
	{
		if (null === $name) {
			$this->name = 'demo';
		} else {
			$this->name = $name;
		}

		return $this;
	}

	public function getAppName()
	{
		return $this->appName;
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