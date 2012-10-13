<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
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