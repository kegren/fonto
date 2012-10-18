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
	const VERSION = '0.2-DEV';
	const DEFAULT_TIMEZONE = 'Europe/Stockholm';

	public $app;

	private $container;

	protected $environment;

	protected $router;

	protected $request;

	protected $loader;

	protected $routes = array();

	protected $controllers;

	public function __construct()
	{
		//Setup application
		$app = $this;

		$this->registerAutoload();

		$this->container = new Container;
		$this->container->add('router', function() use ($app) {
			return new Router($app->routes(), $this->container->get('request'));
		});

		$this->container->add('config', function() {
			return new Config(CONFIGPATH);
		});

		$this->container->add('request', function() {
			return new Request();
		});

		require APPPATH . 'routes' . EXT; /*doh*/

		$env = $this->container->get('config')->get('application', 'environment');
		$this->setEnvironment($env);

		$timezone = $this->container->get('config')->get('application', 'timezone');
		$this->setTimeZone($timezone);

		$this->setExceptionHandler(array(__NAMESPACE__.'\FontoException', 'handle'));
	}

	public function run()
	{
		try {

			$matched = $this->container->get('router')->match();

			if ($matched === false) {
				throw new FontoException("No route was found");
			}

			$route = $matched->run();

		} catch(\Exception $e) {
			echo $e;die(1);
		}

	}

	public function version()
	{
		return self::VERSION;
	}

	public function route($route, $uses)
    {
        $this->routes[$route]  = $uses;

        return $this;
    }

	private function registerAutoload()
	{
		$this->loader = include VENDORPATH . 'autoload' . EXT;
		$this->loader->add('Web', APPPATH . 'src');
	}

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

	private function getEnvironment()
	{
		return $this->environment;
	}

	private function setEnvironment($env = null)
	{
		if (null === $env) {
			$this->environment = 'development';
		} else {
			$this->environment = $env;
		}
		return $this;
	}

	private function setExceptionHandler(array $options = array())
	{
		set_exception_handler($options);
	}

	private function setTimeZone($value = null)
	{
		if (null === $value) {
			date_default_timezone_set(self::DEFAULT_TIMEZONE);
		} else {
			date_default_timezone_set($value);
		}
		return $this;
	}

    private function routes()
    {
    	return $this->routes;
    }

}