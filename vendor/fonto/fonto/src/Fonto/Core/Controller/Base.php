<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto_Controller
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Controller;

use Fonto\Core\Application\App;
use Fonto\Core\Helper\Arr;

class Base extends App
{
    /**
     * @var string
     */
    private $actionPrefix = 'Action';

    /**
     * @var string
     */
    private $defaultAction = 'index';

    /**
     * Constructor.
     */
    public function __construct()
    {
        echo $this->value;
        //parent::__construct();
    }

    /**
     * Filters incoming request against given methods in
     * the controller.
     *
     * @param $filter
     * @param $callback
     * @return mixed
     */
    public function filter($filter, $callback)
    {
        if (is_array($filter)) {
            foreach ($filter as $method) {
                if ($this->checkFilter($method)) {
                    return $callback();
                }
            }
        } else {
            if ($this->checkFilter($filter)) {
                return $callback();
            }
        }

        return false;
    }

    /**
     * Checks if filter matched the request.
     *
     * @param $filter
     * @return bool
     */
    private function checkFilter($filter)
    {
        $reflector = new \ReflectionClass($this);

        if ($reflector->hasMethod($filter . $this->actionPrefix)) {
            $di = new \Fonto\Core\DI\DIManager();
            $request = $di->getService('request');
            $calledClass = get_called_class();
            $filterStr = strtolower(substr($calledClass, strrpos($calledClass, '\\') + 1)); // strrpos start at 0...

            $buildUri = "/$filterStr/$filter";

            $arrHelper = new Arr();
            $arr = explode('/', $request->getRequestUri());
            $cleanedArr = $arrHelper->cleanArray($arr);
            $requestedUri = $request->getRequestUri();

            if (sizeof($cleanedArr) < 2) {
                if (strrpos($requestedUri, '/') > 2) {
                    $requestedUri = $requestedUri . $this->defaultAction;
                } else {
                    $requestedUri = $requestedUri . '/' . $this->defaultAction;
                }
            }

            if ($buildUri == $requestedUri) {
                return true;
            }
        }

        return false;
    }

    /**
     * Magical method for invoking inaccessible methods.
     *
     * @param $class
     * @param $args
     * @return mixed
     */
    public function __call($class, $args)
    {
        $getter = strtolower($class);
        return $this['di']->getService($getter);
    }
}