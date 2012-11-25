<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/Fonto
 */

namespace Fonto\Core\DI;

use Fonto\Core\FontoException;
use Fonto\Core\Application\App;
use \ArrayAccess;
use \Closure;

class Container implements ArrayAccess
{
    /**
     * Services in the container
     *
     * @var array
     */
    protected $services = array();

    /**
     * Registers a service by id
     *
     * @param  string $id
     * @param  string $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if (isset($this->services[$key])) {
            throw new FontoException("There is already an service with $key registered in the container");
        }

        $this->services[$key] = $value;
    }

    /**
     * Checks if the given service is registered in the container
     *
     * @param  string $id
     * @return boolean
     */
    public function offsetExists($key)
    {
        return isset($this->services[$key]);
    }

    /**
     * Unsets a service
     *
     * @param  string $id
     * @return
     */
    public function offsetUnset($key)
    {
        unset($this->services[$key]);
    }

    /**
     * Returns the registered service if exists
     *
     * @param  string $id
     * @return mixed
     */
    public function offsetGet($key)
    {
        if (!isset($this->services[$key])) {
            throw new FontoException("No service is registered with name $key");
        }

        return is_callable($this->services[$key]) ? $this->services[$key]($this) : $this->services[$key];
    }

    /**
     * Registers a callback so it is shared.
     *
     * @param  Closure $callback
     * @return Closure
     */
    public function shared(Closure $callback)
    {
        return function ($c) use ($callback) {
            static $object;

            if (null === $object) {
                $object = $callback($c);
            }

            return $object;
        };
    }
}