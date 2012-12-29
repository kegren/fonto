<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Http;

class Session
{
	/**
	 * Start session
	 */
	public function __construct($sessionName = null)
	{
        $this->setSessionSavePath(SESSPATH);
        if (!$this->isStarted()) {
            $this->setName($sessionName);
            $this->start();
            $this->regenerateId();
        }
	}

    public function start()
    {
        return session_start();
    }

    public function isStarted()
    {
        return session_id();
    }

    public function setName($name = null)
    {
        session_name(($name) ?: 'FontoMVC');
    }

    public function setSessionSavePath($path = null)
    {
        session_save_path(($path) ?: SESSPATH);
    }

	/**
	 * Saves a value
	 *
	 * @param string $id
	 * @param string $value
     *
     * @return \Fonto\Core\Http\Session
     */
	public function save($id, $value)
	{
		$_SESSION[$id] = $value;

		return $this;
	}

	/**
	 * Returns a value from session
	 *
	 * @param  string $id
	 * @return mixed
	 */
	public function get($id)
	{
		if (isset($_SESSION[$id])) {
			return $_SESSION[$id];
		}

		return false;
	}

	/**
	 * Checks if session is set returns boolean
	 *
	 * @param  string $id
	 * @return mixed
	 */
	public function has($id)
	{
		if (isset($_SESSION[$id])) {
			return true;
		}

		return false;
	}


    /**
     * @return Session
     */
    public function regenerateId()
	{
		session_regenerate_id(true);

		return $this;
	}

    /**
     * Returns session value and unsets it
     *
     * @param $id
     * @return string
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
     * Removes a single variable
     *
     * @param string $id
     * @return \Fonto\Core\Http\Session
     */
	public function forget($id)
	{
		if (isset($_SESSION[$id])) {
			unset($_SESSION[$id]);
		}

		return $this;
	}

	/**
	 * Destroys all of the data associated with the current session
	 *
	 * @return void
	 */
	public function forgetAll()
	{
		session_destroy();
	}
}