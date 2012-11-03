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

class Container implements ArrayAccess
{
	protected $services = array();

	protected $app;

	public function __construct(App $app)
	{
		$this->app = $app;
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