<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core;

use Fonto\Core\View;
use Fonto\Core\Application\App;

class Controller
{
	protected $app;

	public function __construct()
	{

	}

	public function setApp(App $app)
	{
		$this->app = $app;
	}

	public function __call($class, $args)
	{
		return $this->app->container[$class];
	}
}