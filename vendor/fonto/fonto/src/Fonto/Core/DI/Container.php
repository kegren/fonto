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

	public function add($name, $value)
	{
		if (isset($this->services[$name])) {
			throw new FontoException("There is already an service with $name registered in the container");
		}
		$this->services[$name] = $value;
	}

	public function get($name)
	{
		if (!isset($this->services[$name])) {
			throw new FontoException("No service is registrerd with name $name");
		}

		if (is_callable($this->services[$name])) {
			return $this->services[$name]();
		} else {
			return $this->services[$name];
		}
	}


}