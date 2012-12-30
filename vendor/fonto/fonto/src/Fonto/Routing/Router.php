<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Routing
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\Routing;

use Fonto\Http\Request;
use Fonto\Routing\Route;
use Exception;

/**
 * Router is responsible for mapping an incoming http request
 * to a route.
 *
 * @package Fonto_Routing
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Router
{
    /**
     * Stores part of current used namespace
     */
    const CONTROLLER_NAMESPACE = '\\Controller';
    /**
     * Stores default route
     */
    const DEFAULT_ROUTE = '/';

    /**
     * @var array
     */
    protected $routes = array();

    /**
     * Route object
     *
     * @var Route
     */
    protected $route;

    /**
     * Request object
     *
     * @var Request
     */
    protected $request;

    /**
     * Supported
     *
     * @var array
     */
    protected $supported = array(
        'mapsTo' => 'string',
        'restful' => 'boolean',
        'name' => 'string',
        'method' => 'string'
    );

    /**
     * Supported restful methods
     *
     * @var array
     */
    protected $supportedMethods = array(
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'HEAD'
    );

    /**
     * Patterns for routes
     *
     * @var array
     */
    private $patterns = array(
        ':num' => '(\d+)',
        ':action' => '([\w\_\-\%]+)'
    );

    /**
     * Constructor
     *
     * Sets route and request objects and includes
     * user defined routes.
     *
     * @param Route   $route
     * @param Request $request
     */
    public function __construct(Route $route, Request $request)
    {
        $this->route = ($route) ? : new Route();
        $this->request = ($request) ? : new Request();
        $router = $this;
        include APPWEBPATH . 'routes.php';
        unset($router);
    }

    /**
     * Adds routes
     *
     * @param string $rule
     * @param array  $options
     */
    public function addRoute($rule, $options)
    {
        $this->routes[$rule] = $options;
    }

    /**
     * Returns routes
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Dispatches a http request to a controller and its method
     *
     * @return mixed
     * @throws Exception
     */
    public function dispatch()
    {
        $namespace = ACTIVE_APP . self::CONTROLLER_NAMESPACE;
        $class = $namespace . '\\' . ucfirst($this->route->getController());

        try {

            if (!class_exists($class)) {
                throw new Exception("The class $class wasn't found");
            }
            $object = new $class;

            $action = $this->getRoute()->getAction();

            if ($this->getRoute()->getRestful()) {
                $httpRequest = strtolower($this->request->getMethod());

                $action = $httpRequest . ucfirst($action);
            }

            if (method_exists($object, $action)) {

                if ($this->getRoute()->getParams()) {
                    return call_user_func_array(array($object, $action), $this->getRoute()->getParams());
                } else {
                    return call_user_func(array($object, $action));
                }

            }
            return false;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Matches the current request with the registered routes
     *
     * @return mixed
     */
    public function match()
    {
        $requestUri = $this->getRequest()->getRequestUri();
        $requestUriArr = explode('/', $requestUri);

        foreach ($this->routes as $route => $options) {

            // Checks if regular route without any patterns
            if (preg_match("#^{$route}$#", $requestUri)) {
                $this->getRoute()->createRoute($options);
                return true;
                break;
            }

            // Checks if registered only as a controller
            if ($route == '<:controller>') {
                $tmpControllers = (array)$options['mapsTo']; // All controllers
                $controllers = array();
                $controller = $requestUriArr[1]; // Controller in uri
                $requestUriArr = array_slice($requestUriArr, 1); // Requested uri

                foreach ($tmpControllers as $control => $option) {
                    if (is_numeric($control)) {
                        $controllers[$option] = $option;
                    }

                    if (is_array($option)) {
                        $controllers[$control] = $option;
                    }
                }

                //Checks if the requested 'controller' is registered
                if (array_key_exists($controller, $controllers)) {

                    if (is_array($controllers[$controller])) {
                        $restfulOption = $controllers[$controller];
                        $restful = isset($restfulOption['restful']) ? : false;

                        if ($restful) {
                            $restfulTrueOrFalse = $restfulOption['restful'];

                            if ($restfulTrueOrFalse) {
                                $isRestful = true;
                            }
                        }
                    }

                    // Sends to route class
                    $this->getRoute()->createRoute(
                        array(
                            'controller' => $controller,
                            'action' => isset($requestUriArr[1]) ? $requestUriArr[1] : 'index',
                            'params' => isset($requestUriArr[2]) ? array_splice($requestUriArr, 2) : array(),
                            'restful' => isset($isRestful) ? $isRestful : false,
                        )
                    );

                    return true;
                    break;
                }

                return false;
                break;
            }

            // Checks pattern
            $route = $this->regexRoute($route);

            // Pattern found and appended
            if ($route) {
                preg_match_all("#^$route$#", $requestUri, $values);

                $value = array_filter(
                    $values,
                    function ($element) {
                        return !empty($element);
                    }
                );

                // Checks if any matches?
                if (!empty($value)) {
                    unset($values[0]); // Remove url
                    $merged = array(
                        'patternParams' => $values
                    );
                    $options = $options + $merged;
                    $this->getRoute()->createRoute($options);
                    return true;
                    break;
                }
            }
        }

        return false;
    }

    /**
     * Sets up regular expressions
     *
     * @param  string $route
     * @return mixed
     */
    protected function regexRoute($route)
    {
        if (preg_match('#:([a-zA-Z0-9]+)#', $route)) {

            foreach ($this->patterns as $prefix => $pattern) {
                $route = str_replace($prefix, $pattern, $route);
            }

            return $route;
        }

        return false;
    }

    /**
     * Returns request object
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Returns route object
     *
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }
}