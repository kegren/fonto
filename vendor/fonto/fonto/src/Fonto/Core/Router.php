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
        '(#all)' => '([0-9a-zA-Z])',
        '(*)' => '(\(\*\))'
    );


    protected $wildcard = '(\(\*\))';

    /**
     * @var array All routes
     */
    protected $routes = array();

    /**
     * @var array
     */
    protected $route = array();

    /**
     * @var array The uri for the route
     */
    protected $uriForRoutes = array();

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

    protected $options;

    protected $routeName;

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
        $this->all        = isset($this->route['all']) ? $this->route['all'] : false;
        $this->controller = $this->route['controller'];
        $this->params     = array_slice($this->uri, 2);

        if ($this->all === true) {
            $this->action = isset($this->uri[1]) ? $this->uri[1] : 'index';
        } else {
            $this->action = $this->route['action'];
        }

        $this->action .= self::ACTION_PREFIX;
        $this->controller = $this->route['controller'];

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

    public function add($namedRoute, $route, $uses = array())
    {
        $this->routes[$namedRoute]  = $route;
        $this->options[$namedRoute] = $uses;

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
        $uri = $this->getRequest();
        // $isAction = strpos($uri, '/') ?: false;

        foreach (array_keys($this->routes) as $route) {
            echo $route;
            if ($route == $uri) {
                $this->routeMatch = true;
                break;
            }
        }

        if (false === $this->routeMatch) {
            throw new FontoException("No route was found for that request");
            return;
        }

        $this->uri = explode('/', $uri);
        foreach ($this->uri as $key => $value) {
            if (strlen($value) == 0) {
                unset($this->uri[$key]);
            }
        }

        $uri = empty($uri) ? '/' : $uri;
        $this->route = $this->routes[$uri];

        return $this;
    }
}