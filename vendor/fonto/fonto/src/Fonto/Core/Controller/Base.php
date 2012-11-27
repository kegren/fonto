<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto.Controller
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Controller;

use Fonto\Core\Application\App;
use Fonto\Core\Helper\Arr;

class Base extends App
{
    private $actionPrefix = 'Action';
    private $defaultAction = 'index';

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

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

    private function checkFilter($filter)
    {
        $reflector = new \ReflectionClass($this);
        echo "<br />";

        if ($reflector->hasMethod($filter . $this->actionPrefix)) {
            $request = $this->getDi()->getService('request');
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
     * @param $class
     * @param $args
     * @return mixed
     */
    public function __call($class, $args)
    {
        $getter = strtolower($class);
        return $this->getDi()->getService($getter);
    }
}