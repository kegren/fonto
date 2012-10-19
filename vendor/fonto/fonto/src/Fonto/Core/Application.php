<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core;

use Fonto\Core\Config,
	Fonto\Core\Router,
	Fonto\Core\Request,
	Fonto\Core\DI\Container;

class Application
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
	 * @var object
	 */
	public $app;

	/**
	 * \Fonto\Core\DI\Container
	 *
	 * @var object
	 */
	protected $container;

	/**
	 * Environment for the application
	 *
	 * @var string
	 */
	private $environment;

	/**
	 * \Fonto\Core\Request
	 *
	 * @var object
	 */
	private $request;

	/**
	 * Storage for all routes
	 *
	 * @var array
	 */
	private $routes = array();

	public function __construct()
	{
		//Setup application
		$app = $this; // Reference for closure

		$this->registerAutoload();

		$this->container = new Container();
		$this->container->add('router', function() use ($app) {
			return new Router($app->routes(), $app->request());
		});

		$this->container->add('config', function() {
			return new Config(CONFIGPATH);
		});

		require APPPATH . 'routes' . EXT;

		$env = $this->container->get('config')->get('application', 'environment');
		$this->setEnvironment($env);

		$timezone = $this->container->get('config')->get('application', 'timezone');
		$this->setTimeZone($timezone);

		$this->setExceptionHandler(array(__NAMESPACE__.'\FontoException', 'handle'));
	}

	/**
	 * Run app
	 */
	public function run()
	{
		try {
			$matched = $this->container()->get('router')->match();

			if ($matched === false) {
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
	public function route($route, $uses)
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
    public function loadActiveRecord()
    {
    	$config = $this->container()->get('config')->get('application', 'database');
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
    }

    public function request()
    {
    	return new Request();
    }

    /**
	 * Get all registered routes
	 *
	 * @return array
	 */
    public function routes()
    {
    	return (array) $this->routes;
    }

    /**
     * Register composers autoloader and add
     * namespace for application
     *
     * @return void
     */
	private function registerAutoload()
	{
		$loader = include VENDORPATH . 'autoload' . EXT;
		$loader->add('Web', APPPATH . 'src');
	}

	/**
	 * Get container
	 *
	 * @return object
	 */
	private function container()
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
	private function setTimeZone($value = null)
	{
		if (null === $value) {
			date_default_timezone_set(self::DEFAULT_TIMEZONE);
		} else {
			date_default_timezone_set($value);
		}
		return $this;
	}
}