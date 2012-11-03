<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Routing;

use Fonto\Core\FontoException;
use Fonto\Core\Request;
use Fonto\Core\Application\App;

class Router
{
    const ACTION_PREFIX        = 'Action';
    const CONTROLLER_NAMESPACE = 'Demo\\Controllers';
    const DEFAULT_ROUTE        = '/';
    const ROUTE_DELIMITER      = '#';
    const DEFAULT_CONTROLLER   = 'home';
    const DEFAULT_ACTION       = 'indexAction';

    /**
     * Patterns for routes
     *
     * @var array
     */
    private $patterns = array(
        '(:num)' => '(\d+)',
        '(:action)' => '([\w\_\-\%]+)'
    );

    /**
     * Registered routes
     *
     * var array
     */
    private $routes;

    /**
     * Registered controllers
     *
     * var array
     */
    private $controllers;

    /**
     * Controller
     *
     * @var string
     */
    public $controller;

    /**
     * Action
     *
     * @var string
     */
    private $action;

    /**
     * Parameters
     *
     * @var string
     */
    private $parameters;


    protected $app;


    public function __construct()
    {
        $this->routes = array();
        $this->parameters = array();
    }

    public function setApp(App $app)
    {
        $this->app = $app;

        return $this;
    }

    public function setRoutes($routes = array())
    {
        $this->routes = $routes;

        return $this;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Route current request
     *
     * @return mixed
     */
    public function run()
    {
        $ns = $this->app->getAppName() . '\\Controllers';
        $class = $ns . '\\' . ucfirst($this->getController());
        $file  = CONTROLLERPATH . ucfirst($this->getController()) . EXT;

        if (!file_exists($file) or (!is_readable($file))) {
            throw new FontoException("The file $file was not found");
        }

        if (!class_exists($class)) {
            throw new FontoException("The class $class does not exist");
        }

        // _vd($this->app->container['controller']);
        // $cls = new $class();

        $reflection = new \ReflectionClass($class);
        $instance   = $reflection->newInstance();
        $method     = "setApp";
        $instance->{$method}($this->app);


        if (method_exists($instance, $this->action)) {

            if (isset($this->params)) {
                call_user_func_array(array($instance, $this->action), $this->params);
            } else {
                call_user_func(array($instance, $this->action));
            }

        } else {
            throw new FontoException("Class: $class does not contain action: $this->action");
        }
    }

    /**
     * Match current request with registered routes
     *
     * @return mixed
     */
    public function match()
    {
        $parsedUriStr = $this->app->container['request']->getRequestUri();
        $parsedUriArr = explode('/', $parsedUriStr);
        $parsedUriArr = array_filter($parsedUriArr);

        list($num, $action) = array_keys($this->patterns);
        list($rNum, $rAction) = array_values($this->patterns);

        foreach ($this->routes as $route => $uses) {

            if ($route == '<:controller>') {
                if (!empty($parsedUriArr)) {
                    if ($parsedUriArr[1] == $uses) {
                        return $this->map($uses, $parsedUriArr);
                    }
                }
            }

            if ($route == $parsedUriStr) {
                return $this->map($uses);
            }

           $route = str_replace(array($num,$action), array($rNum,$rAction), $route);

            if (preg_match('@^' . $route . '$@', $parsedUriStr, $return)) {
                if (!empty($return[0])) {
                    return $this->map($return[0]);
                }
            }
        }

        return false;
    }

    public function map($route, $uri = null)
    {
        if (null === $uri) {

            $delimit = strpos($route, self::ROUTE_DELIMITER) and $delimit = self::ROUTE_DELIMITER;

            if ($delimit) {
                $route = explode($delimit, $route);
            } else {
                $route = explode('/', $route);
            }

            $controller = !empty($route[0]) and $controller = $route[0];
            $action     = !empty($route[1]) and $action = $route[1];
            unset($route[0], $route[1]);
            $parameters = !empty($route[2]) and $parameters = $route;

            $this->setController($controller)
                 ->setAction($action)
                 ->setParameters($parameters);

            return $this;
        }

        $controller = $route;
        $action     = !empty($uri[2]) and $action = $uri[2];
        unset($uri[1], $uri[2]);

        $this->setController($controller)
             ->setAction($action);

        if (!empty($parsedUriArr[3])) {
            $this->setParameters($parsedUriArr);
        }

        return $this;
    }

    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setAction($action)
    {
        $this->action = $action . self::ACTION_PREFIX;

        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    private function setup($route)
    {
        $route = explode('#', $route);

        $controller = !empty($route[0]) ? $route[0] : self::DEFAULT_CONTROLLER;
        $action = !empty($route[1]) ? $route[1] : self::DEFAULT_ACTION;
        unset($route[0]);
        unset($route[1]);
        $parameters = !empty($route) ? $route : array();

        $this->controller($controller);
        $this->action($action);
        $this->parameters($parameters);
    }

}