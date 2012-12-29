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

/**
 * Responsible for creating a route
 *
 * @package Fonto_Routing
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Route
{
    /**
     * Default prefix for action
     */
    const ACTION_PREFIX = 'Action';
    /**
     * Default delimiter for routes
     */
    const ROUTE_DELIMITER = '#';
    /**
     * Default controller
     */
    const DEFAULT_CONTROLLER = 'home';
    /**
     * Default action
     */
    const DEFAULT_ACTION = 'indexAction';

    /**
     * Controller
     *
     * @var string
     */
    protected $controller;

    /**
     * Class method
     *
     * @var string
     */
    protected $action;

    /**
     * Parameters
     *
     * @var array
     */
    protected $params = array();

    /**
     * Restful
     *
     * @var bool
     */
    protected $restful = false;

    /**
     * Http method
     *
     * @var string
     */
    protected $method = 'get';

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
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Builds a route
     *
     * @param  array $route
     * @return bool
     */
    public function createRoute($route)
    {
        if (false === $this->hasMapsTo($route)) {

            if ($this->isRestful($route)) {
                $this->setRestful(true);
            }
            if ($this->hasMethod($route)) {
                $this->setMethod(strtolower($route['method']));
            }

            $this->setController($route['controller']);
            $this->setAction($route['action']);
            $this->setParams($route['params']);
        } else {
            $parsedMapsTo = $this->parseMapTo($route['mapsTo']);

            if ($parsedMapsTo) {
                if ($this->isRestful($route)) {
                    $this->setRestful(true);
                }
                if ($this->hasMethod($route)) {
                    $this->setMethod(strtolower($route['method']));
                }
                if ($this->hasPatternParams($route)) {
                    $patternParams = $route['patternParams'];

                    if (sizeof($patternParams) > 0) {
                        if (sizeof($patternParams) == 1) {
                            $this->setParams($patternParams[1]);
                        } else {
                            $this->setParams($patternParams[2]);
                        }
                    }
                }

                $this->setController($parsedMapsTo[0]);
                $this->setAction($parsedMapsTo[1]);

            } else {
                return false;
            }
        }
    }

    /**
     * Removes route delimiter and returns the route as
     * an array
     *
     * @param  string $mapsTo
     * @return array
     */
    protected function parseMapTo($mapsTo)
    {
        $toArray = explode(self::ROUTE_DELIMITER, $mapsTo);

        return $toArray;
    }

    /**
     * Checks if a route has mapsTo option
     *
     * @param  array $route
     * @return bool
     */
    protected function hasMapsTo($route)
    {
        return isset($route['mapsTo']);
    }

    /**
     * Checks if a route has specified method
     *
     * @param  array $route
     * @return bool
     */
    protected function hasMethod($route)
    {
        return isset($route['method']);
    }

    /**
     * Checks if a route is restful or not
     *
     * @param  array $route
     * @return bool
     */
    protected function isRestful($route)
    {
        return isset($route['restful']) ? $route['restful'] : false;
    }

    /**
     * Checks if a route has pattern params
     *
     * @param  array $route
     * @return bool
     */
    protected function hasPatternParams($route)
    {
        return isset($route['patternParams']);
    }

    /**
     * Sets the action
     *
     * @param string $action
     */
    public function setAction($action = '')
    {
        if (!$action) {
            $this->action = self::DEFAULT_ACTION;
        } else {
            $this->action = $action . self::ACTION_PREFIX;
        }
    }

    /**
     * Returns action
     *
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param  string $controller
     * @return void
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * Returns controller
     *
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Sets parameters
     *
     * @param  $params
     * @return void
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * Returns parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Sets method
     *
     * @param  $method
     * @return void
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Returns method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Sets restful
     *
     * @param  $restful
     * @return void
     */
    public function setRestful($restful)
    {
        $this->restful = (bool)$restful;
    }

    /**
     * Returns restful
     *
     * @return bool
     */
    public function getRestful()
    {
        return $this->restful;
    }
}