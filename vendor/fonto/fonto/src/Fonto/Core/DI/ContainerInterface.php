<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/Fonto
 */

namespace Fonto\Core\DI;

interface ContainerInterface
{
	public function add($name, $value);

	public function get($name);
}