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

    protected $patterns = array(
        '(:all)' => '([0-9a-zA-Z])',
        '(*)' => '(\(\*\))'
    );

    protected $wildcard = '(\(\*\))';

    protected $routeRegex = '(\([\:|\*|\#]([^\>]+)\))';

    /**
     * @var array All routes
     */
    protected $routes = array();

    /**
     * @var array
     */
    protected $route = array();

    /**
     * @var object Request object
     */
    protected $uri;

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
        $this->options = array();
    }


    /**
     * Routes current request
     *
     * @return mixed
     */
    public function dispatch()
    {
        $class = self::CONTROLLER_NAMESPACE . DS . $this->controller;
        $file  = CONTROLLERPATH . $this->controller . EXT;

        if (!file_exists($file) or (!is_readable($file))) {
            throw new FontoException("The file $file was not found");
        }

        if (!class_exists($class)) {
            throw new FontoException("The class $class does not exist");
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

    public function add($route, $uses = array())
    {
        $this->routes[$route]  = $uses;

        return $this;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function setRequest($request)
    {
        $this->uri = $request;

        return $this;
    }

    public function getRequest()
    {
        return $this->uri;
    }

    public function match()
    {
        $uriString = $this->getRequest();
        $uri = ltrim($uriString, '/');
        $uri = explode('/', $uri);

        /**
         * Start by checking if we can find a match in
         * routing array
         */
        foreach (array_keys($this->routes) as $route) {
            if ($route == $uriString) {
                $this->route = $this->routes[$uriString];
                $this->set($route, $uri);
                $this->routeMatch = true;
                break;
            }

            if (preg_match($this->routeRegex, $route)) {
                echo 5;die;
                $r = str_replace('(*)', $uri[1] , $route);
                $modUri = '/' . $uri[0] . '/' . $uri[1];
                if ($modUri == $r) {
                    $this->route = $this->routes[$route];
                    $this->set($route, $uri);
                    $this->routeMatch = true;
                    break;
                }
            }
        }

        if (false === $this->routeMatch) {
            throw new FontoException("No route was found for that request");
            return;
        }

        return $this;
    }

    protected function set($route, $uri)
    {
        if (is_array($uri)) {
            $this->controller = $this->route['controller'];
            $this->action  = isset($this->route['action']) ? $this->route['action'] : 'index';
            $this->action .= self::ACTION_PREFIX;
            $this->params = array_slice($uri, 2);
        } else {
            $this->controller = $this->route['controller'];
            $this->action = !empty($uri[1]) ? $uri[1] : 'index';
            $this->action .= self::ACTION_PREFIX;
            $this->params = array_slice($uri, 2);
        }
    }

}