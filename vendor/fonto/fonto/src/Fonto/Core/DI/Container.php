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
use \ArrayAccess;

class Container implements ArrayAccess
{
	protected $services = array();

	public function __construct($channel = null)
	{}

	public function set($name, $value)
	{
		if (isset($this->services[$name])) {
			throw new FontoException("There is already an service with $name registered in the container");
		}

		$this->services[$name] = $value;
	}

	public function get($name)
	{
		if (!isset($this->services[$name])) {
			throw new FontoException("No service is registered with name $name");
		}

		if (is_callable($this->services[$name])) {
			return $this->services[$name]($this);
		} else {
			return $this->services[$name];
		}
	}

	public function build($class)
	{
		$args = array_slice(func_get_args(), 1);

		$reflection = new \ReflectionClass($class);
		$instance   = $args ? $reflection->newInstanceArgs($args) : $reflection->newInstance();

		return $instance;
	}

	public function offsetSet($offset, $value)
	{
		if (isset($this->services[$offset])) {
			throw new FontoException("There is already an service with $offset registered in the container");
		}

		$this->services[$offset] = $value;
	}

	public function offsetExists($offset)
	{
		//
	}

	public function offsetUnset($offset)
	{
		//
	}

	public function offsetGet($offset)
	{
		if (!isset($this->services[$offset])) {
			throw new FontoException("No service is registered with name $offset");
		}

		if (is_callable($this->services[$offset])) {
			return $this->services[$offset]($this);
		} else {
			return $this->services[$offset];
		}
	}
}