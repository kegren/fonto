<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Routing;

use Fonto\Core\Http\Request;
use Fonto\Core\Routing\Route;
use Exception;

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
     * @var \Fonto\Core\Routing\Route
     */
    protected $route;

    /**
     * @var \Fonto\Core\Http\Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $supported = array(
        'mapsTo' => 'string',
        'restful' => 'boolean',
        'name' => 'string',
        'method' => 'string'
    );

    /**
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
     * @param Route $route
     * @param \Fonto\Core\Http\Request $request
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
     * @param $rule
     * @param $options
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
     * Dispatches request
     *
     * @throws \Exception
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
     * Matches the current request with registered routes
     *
     * @return mixed
     */
    public function match()
    {
        $requestUri = $this->getRequest()->getRequestUri();
        $requestUriArr = explode('/', $requestUri);

        foreach ($this->routes as $route => $options) {

            // Regular route without any patterns?
            if (preg_match("#^{$route}$#", $requestUri)) {
                $this->getRoute()->createRoute($options);
                return true;
                break;
            }

            // Registered only as a controller?
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

                // Is the requested 'controller' registered?
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

                    // Send to route class
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

            // Check pattern
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

                // Any matches?
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
     * @param $route
     * @return bool|mixed
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
     * @return \Fonto\Core\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return \Fonto\Core\Routing\Route
     */
    public function getRoute()
    {
        return $this->route;
    }
}