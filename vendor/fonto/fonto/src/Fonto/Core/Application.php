<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 */

namespace Fonto\Core;

use Fonto\Core\Config;

class Application
{
	const VERSION = '0.2-DEV';

	protected $app;

	protected $environment;

	protected $config;

	public function __construct()
	{
		//Setup application
		$app = $this;
	}

	public function run()
	{
		//Run application
	}

	public function getEnvironment()
	{
		return $this->environment;
	}

	public function getConfig()
	{
		return $this->config = new Config();
	}

}