<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Authentication;

use Fonto\Core\Application\App;

class Auth
{
	/**
	 * User object
	 *
	 * @var object
	 */
	private $user;

	/**
	 * Fonto\Core\Application\App
	 *
	 * @var object
	 */
	private $app;

	public function __construct()
	{}

    /**
     * Sets the current application
     *
     * @param App $app
     */
	public function setApp(App $app)
	{
		$this->app = $app;
	}

	/**
	 * Authenticates an user by checking if username exists
	 * and if the provided password is correct
	 *
	 * @param  string $username
	 * @param  string $password
	 * @return boolean
	 */
	public function authenticate($username, $password)
	{
		$modelNs = $this->app->getAppName() . '\\Models\\';
		$user = new $modelsNs.User();
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

	/**
	 * Returns true if an session is set false otherwise
	 *
	 * @return boolean
	 */
	public function IsAuthenticated()
	{
		return $this->app->getSession()->get('user');
	}

	/**
	 * Gets user id from current logged in user
	 *
	 * @return mixed
	 */
	public function getId()
	{
		$getId = $this->app->getSession()->get('user');

		if ($getId) {
			if (isset($getId['id'])) {
				return $getId['id'];
			}
		}

		return false;
	}

	/**
	 * Validates password
	 *
	 * @param  string $password
	 * @return boolean
	 */
	private function validatePassword($password)
	{
		return $this->app->getPhpass()->CheckPassword($password, $this->user->password);
	}

	/**
	 * Sets session credentials based on user object
	 *
	 * @param  User $user
	 * @return void
	 */
	private function login($user)
	{
		$roles 	  = $this->setRoles($user);
		$userData = $user->to_array(array(
			'only' => array('id', 'username')
		));

		$sessionData = $userData + $roles;

		$session = $this->app->getSession();
		$session->set('user', $sessionData);
	}

	/**
	 * Returns user roles as an array
	 *
	 * @param User $user
	 */
	private function setRoles($user)
	{
		$arr = array();
		foreach ($user->roles as $role) {
			$arr['roles'][] = $role->name;
		}

		return $arr;
	}

}