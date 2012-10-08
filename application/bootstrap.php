<?php

/**
 * Include files
 */
include $paths['app'] . 'helpers' . EXT;
include $paths['core'] . 'Autoloader' . EXT;
include $paths['core'] . 'FontoException' . EXT;

/**
 * Namespace shortcuts
 */
use Fonto\Core\Request as Request,
	Fonto\Core\Router as Router,
	Fonto\Core\Route as Route,
	Fonto\Core\Config as Config,
	Fonto\Core\FontoException as FontoException,
	Fonto\Core\Autoloader as Autoloader;


/**
 * Set custom exception handling
 */
set_exception_handler(array('\Fonto\Core\FontoException', 'handle'));


/**
 * Register autoloading
 */
$autoloader = new Autoloader();
$autoloader->register();

/**
 * Timezone
 */
date_default_timezone_set(Config::read('application', 'timezone'));

/**
 * Set/Get all routes
 */
$routes = include $paths['app'] . 'routes' . EXT;

/**
 * Instantiates objects and sets routes
 */
$route = new Route();
$route->addRoutes($routes);

$request = new Request();
$router = new Router($request, $route);
$router->route();

unset($paths);