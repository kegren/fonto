<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/Fonto
 */

namespace Fonto\Core;

use Fonto\Core\FontoException,
    Fonto\Core\Request;

class Router
{
    const ACTION_PREFIX        = 'Action';
    const CONTROLLER_NAMESPACE = 'Web\Controllers';
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
     * Controller
     *
     * @var string
     */
    private $controller;

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

    /**
     * Fonto\Core\Request object
     *
     * @var object
     */
    private $request;


    public function __construct(array $routes = array(), Request $request)
    {
        $this->routes = $routes;
        $this->request = $request;
    }

    /**
     * Route current request
     *
     * @return mixed
     */
    public function run()
    {
        $class = self::CONTROLLER_NAMESPACE . DS . ucfirst($this->controller());
        $file  = CONTROLLERPATH . ucfirst($this->controller()) . EXT;

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

            if (preg_match('@^' . $route . '$@', $this->request->getRequestUri(), $return)) {
                $this->setup($uses."#".end($return));
                return $this;
                break;
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