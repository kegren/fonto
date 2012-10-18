<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/Fonto
 */

namespace Fonto\Core;

use Fonto\Core\View;

abstract class Controller
{
	abstract public function indexAction();

	public function view($file, $data = null)
	{
		return new View($file, $data);
	}
}