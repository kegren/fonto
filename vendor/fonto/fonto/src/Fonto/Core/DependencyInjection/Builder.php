<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\DependencyInjection;

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
        $this->_args = $service['_args'];

        if (sizeof($this->_args)) {
            $argsOfArgs = array();
            foreach ($this->_args as $_arg) {

                $class = $_arg['class'];
                $args = $_arg['args'];

                if ($this->args[$class]) {
                    unset($this->args[$class]);
                }

                foreach ($args as $arg) {
                    $argsOfArgs[$arg] = $this->instance($arg);
                }

                $this->uses[$class] = $this->instance($class, $argsOfArgs);
            }
        }

        foreach ($this->args as $named => $class) {
            $this->uses[$named] = $this->instance($class);
        }

        $this->uses = array_reverse($this->uses);

        return $this->instance($this->class, $this->uses);
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
