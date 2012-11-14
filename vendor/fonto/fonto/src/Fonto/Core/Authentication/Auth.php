<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Authentication;

class Auth
{
	private $user;
	private $app;

	public function __construct()
	{}

	public function authenticate($username, $password)
	{
		$user = new User();
		$user = User::find_by_username('fonto');

		if ($user) {

			$this->user = $user;

			if ($this->validatePassword('admin')) {

				$this->login($this->user);

				return true;
			}

		}

		return false;
	}

}