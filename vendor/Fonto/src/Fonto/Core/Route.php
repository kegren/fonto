<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 */

namespace Fonto\Core;

use Fonto\Core\Router;

class Route implements IRoute
{

	/**
	 * Store all routes
	 *
	 * @var array
	 */
	private $routes = array();

	/**
	 * Current route
	 *
	 * @var string
	 */
	public $route;

	/**
	 * Controller for current route
	 *
	 * @var string
	 */
	public $controller;

	/**
	 * Action for current route
	 *
	 * @var string
	 */
	public $action;

	/**
	 * Parameters for current route
	 *
	 * @var string
	 */
	public $params;

	/**
	 * Load all actions automatically default false
	 *
	 * @var boolean
	 */
	public $all = false;

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