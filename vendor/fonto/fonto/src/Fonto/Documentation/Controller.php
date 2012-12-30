<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Documentation
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\Documentation;

use Fonto\Application\ObjectHandler;
use ReflectionClass;
use ReflectionMethod;

/**
 * Gets all registered controllers.
 *
 * @package Fonto_Documentation
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Controller extends ObjectHandler
{
    /**
     * All controllers
     *
     * @var array
     */
    private $controllers = array();

    /**
     * Controller namespace
     *
     * @var string
     */
    private $namespace;

    /**
     * Methods not to display
     *
     * @var array
     */
    private $skipArguments = array(
        '__construct' => 'constructor',
        '__destruct' => 'destructor',
    );

    /**
     * Restful prefixes
     *
     * @var array
     */
    private $controllerPrefixes = array(
        'get',
        'post',
        'delete',
        'head'
    );

    /**
     * Default action prefix
     *
     * @var string
     */
    private $controllerActionPrefix = 'Action';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $controllers = $this->router()->getRoutes();

        $this->controllers = $controllers['<:controller>']['mapsTo'];
        $this->namespace = ACTIVE_APP . '\\Controller\\';
    }

    /**
     * Returns all controllers
     *
     * @return array
     */
    public function getAll()
    {
        $controllers = array();

        // Loops through all controllers and their arguments
        foreach ($this->controllers as $name => $option) {
            // If numeric than no arguments is defined for the controller
            if (is_numeric($name)) {
                $class = $this->namespace . ucfirst($option);
                $reflection = new ReflectionClass($class);
                $name = $option;
            } else {
                $class = $this->namespace . ucfirst($name);
                $reflection = new ReflectionClass($class);
            }

            $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {

                if (!array_key_exists($method->name, $this->skipArguments)) {
                    if ($method->class == $class) {

                        if (strpos($method->name, "post") !== false) {
                            continue;
                        }

                        if (strpos($method->name, "get") !== false) {
                            $methodName = strtolower(str_replace($this->controllerPrefixes, array(''), $method->name));
                        } else {
                            $methodName = strtolower($method->name);
                        }

                        if (strpos($methodName, "action") !== false) {
                            $methodName = substr($methodName, 0, strpos($methodName, "action"));
                        }

                        $controllers[$name][] = $methodName;
                    }
                }
            }
            sort($controllers[$name], SORT_LOCALE_STRING);
        }

        ksort($controllers, SORT_LOCALE_STRING);
        return $controllers;
    }

}