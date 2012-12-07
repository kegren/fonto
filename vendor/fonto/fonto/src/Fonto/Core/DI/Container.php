<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto.DI
 * @link https://github.com/kenren/Fonto
 */

namespace Fonto\Core\DI;

use Fonto\Core\FontoException;
use \Closure;

class Container
{
    /**
     * Services in the container
     *
     * @var array
     */
    protected $services = array();

    public function __construct()
    {}

    /**
     * Registers a service by id
     *
     * @param $key
     * @param  string $value
     * @throws \Fonto\Core\FontoException
     * @internal param string $id
     * @return void
     */
    public function setService($key, $value)
    {
        if (isset($this->services[$key])) {
            throw new FontoException("There is already an service named {$key} registered in the container");
        }

        $this->services[$key] = $value;

        return $this;
    }

    /**
     * Returns the registered service if exists
     *
     * @param $key
     * @throws \Fonto\Core\FontoException
     * @internal param string $id
     * @return mixed
     */
    public function getService($key)
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

    /**
     * @return array
     */
    public function getRegisteredServices()
    {
        return array_keys($this->services);
    }
}