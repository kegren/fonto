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

class Base extends App
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function filter($filter, $redirectTo, $callback)
    {
        $reflector = new \ReflectionClass($this);

        if ($reflector->hasMethod($filter.'Action')) {
            $request = $this->getDi()->getService('request');
            $calledClass = get_called_class();
            $filterStr = strtolower(substr($calledClass, strrpos($calledClass, '\\') + 1));   // strrpos start at 0...

            $buildUri = "/$filterStr/$filter";

            if ($buildUri == $request->getRequestUri()) {
                $redirect = $this->getDi()->getService('response');
                $redirect->redirect($redirectTo);

                $callback();
            }
        }
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