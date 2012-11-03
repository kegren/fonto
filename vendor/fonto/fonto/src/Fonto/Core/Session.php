<?php

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

}