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

class Container implements ContainerInterface
{
	protected $services = array();

	protected $name;

	public function __construct($name)
	{
		$this->name = $name;
	}

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
}