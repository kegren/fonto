<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core;

class Session
{

	public function __construct()
	{
		@session_start();
	}

	public function set($id, $value)
	{
		$_SESSION[$id] = $value;

		return $this;
	}

	public function get($id)
	{
		return $_SESSION[$id];
	}

	public function flashMessage($id)
	{
		if (isset($_SESSION[$id])) {
			$message = $_SESSION[$id];
			unset($_SESSION[$id]);
			return $message;
		}

		return '';
	}

}