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
	/**
	 * Start session
	 */
	public function __construct()
	{
		@session_start();
	}

	/**
	 * Setting a value
	 *
	 * @param string $id
	 * @param string $value
	 */
	public function set($id, $value)
	{
		$_SESSION[$id] = $value;

		return $this;
	}

	/**
	 * Returning a value from session
	 *
	 * @param  string $id
	 * @return session value
	 */
	public function get($id)
	{
		return $_SESSION[$id];
	}

	/**
	 * Getter for flash massages.
	 *
	 * @param  string $id
	 * @return mixed
	 */
	public function flashMessage($id)
	{
		if (isset($_SESSION[$id])) {
			$message = $_SESSION[$id];
			unset($_SESSION[$id]);
			return $message;
		}

		return '';
	}

	/**
	 * Flush specified session var
	 *
	 * @param  string $id
	 * @return this
	 */
	public function flush($id)
	{
		if (isset($_SESSION[$id])) {
			unset($_SESSION[$id]);
		}

		return $this;
	}

}