<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/Fonto
 */

namespace Fonto\Core;

use Fonto\Core\Router;

class Route
{

	/**
	 * @var string Current route
	 */
	protected $route;

	/**
	 * @var string Controller for current route
	 */
	protected $controller;

	/**
	 * @var string Action for current route
	 */
	protected $action;

	/**
	 * @var string Parameters for current route
	 */
	protected $params;

	/**
	 * @var boolean Load all actions automatically default false
	 */
	protected $all = false;

	public function __construct()
	{
		;
	}

	/**
	 * Add routes
	 *
	 * @param array $routes
	 */
	public function addRoutes(array $routes = array())
	{
		$this->routes = $routes;
	}

	/**
	 * Get all routes
	 *
	 * @return array
	 */
	public function getRoutes()
	{
		return $this->routes;
	}

	/**
	 * Create route and set responding controller with action
	 *
	 * @param  string $route
	 * @return boolean
	 */
	public function create($route)
	{
		if (isset($this->routes[$route])) {
			if ($this->routes[$route]['all'] === false) {
				$this->route      = $route;
				$this->controller = $this->routes[$route]['controller'];
				$this->action     = $this->routes[$route]['action'].'Action';
				$this->all        = $this->routes[$route]['all'];
				return true;
			} else {
				$this->route = $route;
				$this->all   = $this->routes[$route]['all'];
				return true;
			}
		}

		return false;
	}
}