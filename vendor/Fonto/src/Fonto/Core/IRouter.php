<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 */

namespace Fonto\Core;

interface IRouter
{
	public function route();

	public function match($uri);
}