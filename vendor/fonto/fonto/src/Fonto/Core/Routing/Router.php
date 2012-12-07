<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Routing;

use Fonto\Core\FontoException;
use Fonto\Core\Http\Request;
use Fonto\Core\Routing\Route;
use Fonto\Core\DI;
use Fonto\Core\Routing\Exception;

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
     * @return routes
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Routes the request
     *
     * @throws Exception\MethodNotFound
     */
    public function dispatch()
    {
        $namespace = ACTIVE_APP . self::CONTROLLER_NAMESPACE;
        $class = $namespace . '\\' . ucfirst($this->route->getController());

        try {

            if (!class_exists($class)) {
                throw new \Fonto\Core\Routing\Exception\ClassNotFound("The class $class wasn't found");
            }
            $object = new $class;

            $action = $this->getRoute()->getAction();

            if ($this->getRoute()->getRestful()) {
                $httpRequest = strtolower($this->request->getMethod());

                $action = $httpRequest . ucfirst($action);
            }

            if (method_exists($object, $action)) {

                if ($this->getRoute()->getParams()) {
                    call_user_func_array(array($object, $action), $this->getRoute()->getParams());
                } else {
                    call_user_func(array($object, $action));
                }

            } else {
                throw new \Fonto\Core\Routing\Exception\MethodNotFound("The class $class doesn't have a method called $action");
            }

        } catch (\Exception $e) {
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
        $di = new DI\DIManager();
        $arrHelper = $di->getService('Arr');
        $requestUriArr = $arrHelper->cleanArray($requestUriArr);

        foreach ($this->routes as $route => $options) {

            // Regular route without any patterns?
            if (preg_match("#^{$route}$#", $requestUri)) {
                $this->getRoute()->createRoute($options);
                return true;
                break;
            }

            // Registered only as a controller?
            if ($route == '<:controller>') {
                $controllers = (array)$options['mapsTo'];
                $controller = $requestUriArr[1];
                $requestUriArr = array_slice($requestUriArr, 1);

                if (in_array($controller, $controllers)) {
                    unset($options['mapsTo']);
                    $merged = array(
                        'controller' => $controller,
                        'action' => isset($requestUriArr[0]) ? $requestUriArr[0] : '',
                        'params' => isset($requestUriArr[1]) ? array_splice($requestUriArr, 1) : array(),
                    );
                    $options = $options + $merged;
                    $this->getRoute()->createRoute($options);
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

               // Any matches?
               if (sizeof($values) > 0) {
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