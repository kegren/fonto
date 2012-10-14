<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 */

namespace Fonto\Core;

use Fonto\Core\Request,
    Fonto\Core\Route,
    Fonto\Core\Config,
    Fonto\Core\FontoException;

class Router
{
    const ACTION_PREFIX        = 'Action';
    const CONTROLLER_NAMESPACE = 'Web\\Controllers';
    const DEFAULT_ROUTE        = '/';

    // protected $patterns = array(
    //     '(#all)' => '([0-9a-zA-Z])'
    // );
    //

    /**
     * @var array All routes
     */
    protected $routes = array();

    /**
     * @var array The uri for the route
     */
    protected $uriForRoutes = array();

    /**
     * @var object Request object
     */
    protected $requestUri;


    /**
     * @var boolean Did we found a matching route?
     */
    protected $routeMatch = false;

    /**
     * @var string Controller
     */
    protected $controller;

    /**
     * @var string Action
     */
    protected $action;

    /**
     * @var string Parameters
     */
    protected $params;

    /**
     * Set objects
     *
     * @param Request $request
     * @param Route   $route
     */
    public function __construct()
    {
        ;
    }


    /**
     * Routes current request
     *
     * @return mixed
     */
    public function dispatch()
    {
        $class = Router::CONTROLLER_NAMESPACE . DS . $this->controller;
        $file  = CONTROLLERPATH . $this->controller . EXT;

        if (!file_exists($file) or (!is_readable($file))) {
            throw new FontoException("The file $file was found");
        }

        if (!class_exists($class)) {
            throw new FontoException("The class $class was found in the $file");
        }

        $cls = new $class();

        if (method_exists($cls, $this->action)) {

            if (isset($this->params)) {
                call_user_func_array(array($cls, $this->action), $this->params);
            } else {
                call_user_func(array($cls, $this->action));
            }

        } else {
            throw new FontoException("Class: $class does not contain action: $this->action", 404);
        }
    }

    public function map($routes = array())
    {
        $uriForRoute = array_keys($routes);
        $this->setUriForRoutes($uriForRoute);
        $this->routes = $routes;
    }

    public function route()
    {
        if (isset($this->routes[$this->requestUri])) {

            $route = $this->routes[$this->requestUri];

            $uri = explode('/', $this->requestUri);
            foreach ($uri as $key => $value) {
                if (strlen($value) == 0) {
                    unset($uri[$key]);
                }
            }

            $this->all        = isset($route['all']) ? $route['all'] : false;
            $this->controller = $route['controller'];
            $this->params     = array_slice($uri, 2);

            if ($this->all === true) {
                $this->action = isset($uri[1]) ? $uri[1] : '';
            } else {
                $this->action = $route['action'];
            }

            $this->action .= Router::ACTION_PREFIX;
            $this->controller = $route['controller'];

            $this->dispatch();
            return;
        }

        throw new FontoException("No route was found!", 404);
    }
}