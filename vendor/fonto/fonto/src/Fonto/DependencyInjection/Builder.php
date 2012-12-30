<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_DependencyInjection
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\DependencyInjection;

use Exception;
use ReflectionClass;

/**
 * Builds a service and its dependencies.
 *
 * @package Fonto_DependencyInjection
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Builder
{
    /**
     * Current class
     *
     * @var
     */
    protected $class;

    /**
     * Dependency instances
     *
     * @var array
     */
    protected $uses = array();

    /**
     * Dependencies
     *
     * @var array
     */
    protected $args = array();

    /**
     * Internal dependencies for dependencies
     *
     * @var array
     */
    protected $_args = array();

    /**
     * Constructor
     */
    public function __construct()
    {}

    /**
     * Builds a service and sets up dependencies. Returns an object
     * with all necessary dependencies set.
     *
     * @param  $service
     * @return object
     */
    public function build($service)
    {
        $this->class = $service['class'];
        $this->args = $service['args'];
        $this->_args = isset($service['_args']) ? $service['_args'] : array();
        $order = $this->args;
        $sorted = '';

        if (sizeof($this->_args)) {
            $argsOfArgs = array();

            foreach ($this->_args as $_arg) {

                $id = $_arg['id'];
                $class = $_arg['class'];
                $args = $_arg['args'];

                if (isset($this->args[$id])) {
                    unset($this->args[$id]);
                }

                foreach ($args as $arg) {
                    $argsOfArgs[$arg] = $this->instance($arg);
                }

                $this->uses[$id] = $this->instance($class, $argsOfArgs);
            }
        }

        foreach ($this->args as $named => $class) {
            $this->uses[$named] = $this->instance($class);
        }

        // Sorts by defined order
        foreach ($order as $key => $value) {
            $sorted[$key] = $this->uses[$key];
        }

        return $this->instance($this->class, $sorted);
    }

    /**
     * Uses reflection to create a new instance either with or without
     * arguments
     *
     * @param  $class
     * @param  array $args
     * @return object
     * @throws Exception
     */
    protected function instance($class, $args = array())
    {
        if (!is_string($class) or empty($class)) {
            throw new Exception("The class most be a string and cant be empty");
        }

        $reflection = new ReflectionClass($class);

        if (sizeof($args)) {
            return $reflection->newInstanceArgs($args);
        }

        return $reflection->newInstance();
    }
}
