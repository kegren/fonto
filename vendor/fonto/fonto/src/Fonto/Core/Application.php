<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/Fonto
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

	private $container;

	protected $environment;

	/**
	 * \Fonto\Core\Request
	 *
	 * @var object
	 */
	protected $request;

	/**
	 * Storage for all routes
	 *
	 * @var array
	 */
	protected $routes = array();

	public function __construct()
	{
		//Setup application
		$app = $this;

		$app->registerAutoload();

		$app->container = new Container;
		$app->container->add('router', function() use ($app) {
			return new Router($app->routes(), $app->request());
		});

		$app->container->add('config', function() {
			return new Config(CONFIGPATH);
		});

		require APPPATH . 'routes' . EXT; /*doh*/

		$env = $app->container->get('config')->get('application', 'environment');
		$app->setEnvironment($env);

		$timezone = $app->container->get('config')->get('application', 'timezone');
		$app->setTimeZone($timezone);

		$app->setExceptionHandler(array(__NAMESPACE__.'\FontoException', 'handle'));
	}

	/**
	 * Run application!
	 *
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
     * @return void
     */
    public function loadActiveRecord()
    {
     	\ActiveRecord\Config::initialize(function($cfg)
		{
			$config = $this->container()->get('config')->get('application');
			$type = $config['database']['type'];
	    	$host = $config['database']['host'];
	    	$user = $config['database']['user'];
	    	$pass = $config['database']['pass'];
	    	$name = $config['database']['name'];
     		$cfg->set_model_directory(MODELPATH);
	    	$cfg->set_connections(array(
	    	'development' => "$type://$user:$pass@$host/$name"));
 		});
    }

    private function request()
    {
    	return new Request();
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

	/**
	 * Get all registered routes
	 *
	 * @return array
	 */
    private function routes()
    {
    	return (array) $this->routes;
    }

}