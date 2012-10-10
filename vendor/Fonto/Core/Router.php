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

class Router Implements IRouter
{
    const ACTION_PREFIX        = 'Action';
    const CONTROLLER_NAMESPACE = 'Application\Controllers';

    /**
     * Request object
     *
     * @var object
     */
    private $request = null;

    /**
     * Route object
     *
     * @var object
     */
    private $route = null;

    /**
     * Array containing uri parts
     *
     * @var array
     */
    private $parts = array();

    /**
     * Set objects
     *
     * @param Request $request
     * @param Route   $route
     */
    public function __construct(Request $request, Route $route)
    {
        $this->request = $request;
        $this->route   = $route;

        $this->getPartsFromUri();
    }


    /**
     * Routes current request
     *
     * @return mixed
     */
    public function route()
    {
        if ($this->match($this->parts['route'])) {

            if ($this->route->all) {

                $namespacedClass = Router::CONTROLLER_NAMESPACE . DS . $this->parts['controller'];

                if (!class_exists($namespacedClass)) {
                    throw new FontoException("No class with name $namespacedClass was found", 404);
                }

                $controller = $this->parts['controller'];
                $action     = $this->parts['action'];
                $params     = $this->parts['params'];

                $inspekt = new \ReflectionClass($namespacedClass);
                if ($inspekt->hasMethod($action))
                {
                    $c = new $namespacedClass();
                    call_user_func_array(array($c, $action), $params);
                } else {
                    throw new FontoException("Class: $namespacedClass does not contain action: $action", 404);
                }

            } else {
                $controller      = $this->route->controller;
                $action          = $this->route->action;
                $params          = $this->parts['params'];
                $namespacedClass = Router::CONTROLLER_NAMESPACE . DS . $controller;

                if (!class_exists($namespacedClass)) {
                    throw new FontoException("No class with name $namespacedClass was found", 404);
                }

                $inspekt = new \ReflectionClass($namespacedClass);
                if ($inspekt->hasMethod($action))
                {
                    $c = new $namespacedClass();
                    call_user_func_array(array($c, $action), $params);
                } else {
                    throw new FontoException("Class: $namespacedClass does not contain action: $action", 404);
                }

            }
        } else {
            throw new FontoException("No route was found!", 404);
        }
    }

    /**
     * Match requested uri against routes
     *
     * @param  string $route
     * @return boolean
     */
    public function match($route)
    {
        $setRoute = $this->route->create($route);

        if ($setRoute) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Create routes from uri.
     *
     * @return void
     */
    private function getPartsFromUri()
    {
        $uri = $this->request->getRequestUri();

        $iRoute      = !empty($uri[0]) ? $uri[0] : '/';
        $iController = !empty($uri[0]) ? $uri[0] : '';
        $iAction     = !empty($uri[1]) ? $uri[1].Router::ACTION_PREFIX : 'indexAction';
        $iParams     = array_slice($uri, 2);

        $this->parts = array(
            'route'      => $iRoute,
            'controller' => $iController,
            'action'     => $iAction,
            'params'     => $iParams
        );
    }
}