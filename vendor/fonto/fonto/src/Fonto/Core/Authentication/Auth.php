<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Authentication;

use Hautelook\Phpass\PasswordHash;
use Fonto\Core\Application\App;

class Auth
{
	private $user;
	private $app;

	public function __construct()
	{}

	public function authenticate($username, $password)
	{
		$user = new User();
		$user = User::find_by_username($username);

		if ($user) {

			$this->user = $user;

			if ($this->validatePassword($password)) {

				$this->login($this->user);

				return true;
			}

		}

		return false;
	}

	private function validatePassword($password)
	{
		$passwordChecker = new PasswordHash(8, false);
		return $passwordChecker->CheckPassword($password, $this->user->password);
	}

}