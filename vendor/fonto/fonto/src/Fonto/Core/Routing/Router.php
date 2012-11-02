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
        '(:action)' => '([\w\_\-\%]+)',
        '<:controller>' => '([\w\_\-\%]+)'
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
        $this->controllers = array();
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

    public function setControllers($controllers = array())
    {
        $this->controllers = $controllers;

        return $this;
    }


    /**
     * Route current request
     *
     * @return mixed
     */
    public function run()
    {
        $ns = $this->app->getAppName() . '\\Controllers';
        $class = $ns . '\\' . ucfirst($this->controller());
        $file  = CONTROLLERPATH . ucfirst($this->controller()) . EXT;

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
        $requestedUri = $this->app->container['request']->getRequestUri();
        $match = false;

        list($num, $action, $controller) = array_keys($this->patterns);
        list($rNum, $rAction, $rController) = array_values($this->patterns);

        foreach ($this->routes as $route => $uses) {

           $route = str_replace(array(
                $num,
                $action,
                $controller
            ), array(
                $rNum,
                $rAction,
                $rController
            ), $route);

            if (preg_match('@^' . $route . '$@', $requestedUri, $return)) {
                $this->setup($uses."#".end($return));
                $match = true;
                return $this;
                break;
            }
        }

        if (false === $match) {
            $uri = explode('/', $requestedUri);
            $uri = array_filter($uri); // Array 1

            foreach ($this->controllers as $controller) {
                if ($uri[1] === $controller) {
                    $this->controller = $controller;
                    $this->action = !empty($uri[2]) ? $uri[2] : '';
                    $this->parameters = array_slice($uri, 2);
                    break;
                }
            }

        }

        return false;
    }

    public function controller($controller = null)
    {
        if (is_null($controller)) {
            return $this->controller;
        }

        $this->controller = (string) $controller;
    }

    public function action($action = null)
    {
        if (is_null($action)) {
            return $this->action;
        }

        $this->action = (string) $action . self::ACTION_PREFIX;
    }

    public function parameters($parameters = null)
    {
        if (is_null($parameters)) {
            return $this->parameters;
        }

        $this->parameters = (array) $parameters;
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