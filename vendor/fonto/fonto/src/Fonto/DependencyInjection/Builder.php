<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\DependencyInjection;

use Exception;
use ReflectionClass;

class Builder
{
    /**
     * @var
     */
    protected $class;

    /**
     * @var array
     */
    protected $uses = array();

    /**
     * @var array
     */
    protected $args = array();

    /**
     * @var array
     */
    protected $_args = array();

    public function __construct()
    {}

    /**
     * @param $service
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

        // Sort by defined order
        foreach ($order as $key => $value) {
            $sorted[$key] = $this->uses[$key];
        }

        return $this->instance($this->class, $sorted);
    }

    /**
     * @param $class
     * @param array $args
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
