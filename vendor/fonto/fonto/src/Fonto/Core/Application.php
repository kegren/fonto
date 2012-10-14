<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 */

namespace Fonto\Core;

use Fonto\Core\Config,
	Fonto\Core\Router,
	Fonto\Core\Request;

class Application
{
	const VERSION = '0.2-DEV';
	const DEFAULT_TIMEZONE = 'Europe/Stockholm';

	public $app;

	protected $environment;

	protected $config;

	protected $router;

	protected $request;

	public function __construct()
	{
		//Setup application
		$app = $this;

		$this->config  = new Config();
		$this->request = new Request();
		$this->router  = new Router();

		$env = $this->config->get('application', 'environment');
		$this->setEnvironment($env);

		$timezone = $this->config->get('application', 'timezone');
		$this->setTimeZone($timezone);

		$this->setExceptionHandler(array(__NAMESPACE__.'\FontoException', 'handle'));
	}

	public function run()
	{
		//Run application
		$this->getRouter()->dispatch();
	}

	protected function setErrorReporting()
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

	protected function getEnvironment()
	{
		return $this->environment;
	}

	protected function setEnvironment($env = null)
	{
		if (null === $env) {
			$this->environment = 'development';
		} else {
			$this->environment = $env;
		}
		return $this;
	}

	protected function setExceptionHandler(array $options = array())
	{
		set_exception_handler($options);
	}

	protected function getConfig()
	{
		return $this->config;
	}

	protected function getRequest()
	{
		return $this->request;
	}

	protected function getRouter()
	{
		return $this->router;
	}

	protected function setTimeZone($value = null)
	{
		if (null === $value) {
			date_default_timezone_set(self::DEFAULT_TIMEZONE);
		} else {
			date_default_timezone_set($value);
		}
		return $this;
	}


}