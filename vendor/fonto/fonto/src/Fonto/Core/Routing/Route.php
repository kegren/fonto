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
     * @var
     */
    protected $controller;

    /**
     * @var
     */
    protected $action;

    /**
     * @var array
     */
    protected $params = array();

    /**
     * @var bool
     */
    protected $restful = false;

    /**
     * @var string
     */
    protected $method = 'get';

    protected $supported = array(
        'mapsTo' => 'string',
        'restful' => 'boolean',
        'name' => 'string',
        'method' => 'string'
    );

    /**
     * Constructor
     */
    public function __construct() {}

    /**
     * Builds the route
     *
     * @param $route
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
     * @param $mapTo
     * @return array
     */
    protected function parseMapTo($mapTo)
    {
        $toArray = explode(self::ROUTE_DELIMITER, $mapTo);
        $di = new \Fonto\Core\DI\DIManager();
        $helperArr = $di->getService('Arr');
        $toArray = $helperArr->cleanArray($toArray);

        return (array)$toArray;
    }

    /**
     * @param $route
     * @return bool
     */
    protected function hasMapsTo($route)
    {
        return isset($route['mapsTo']);
    }

    /**
     * @param $route
     * @return bool
     */
    protected function hasMethod($route)
    {
        return isset($route['method']);
    }

    /**
     * @param $route
     * @return bool
     */
    protected function isRestful($route)
    {
        return $route['restful'] == true;
    }

    /**
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
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param $restful
     */
    public function setRestful($restful)
    {
        $this->restful = (bool)$restful;
    }

    /**
     * @return bool
     */
    public function getRestful()
    {
        return $this->restful;
    }
}