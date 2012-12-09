<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto.Session
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Session;

class Base
{
	/**
	 * Start session
	 */
	public function __construct($sessionName = null)
	{
        session_save_path(SESSPATH);
        if (!$this->isStarted()) {
            session_name(isset($sessionName) ? $sessionName : 'FontoMVC');
            session_start();
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
	 * Sets a value
	 *
	 * @param string $id
	 * @param string $value
     * @return \Fonto\Core\Session\Base
     */
	public function set($id, $value)
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
     * @return Base
     */
    public function regenerateId()
	{
		session_regenerate_id(true);

		return $this;
	}

	/**
	 * Gets flash massages
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
     * Erases session variable
     *
     * @param string $id
     * @return \Fonto\Core\Session\Base
     */
	public function erase($id)
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
	public function eraseAll()
	{
		session_destroy();
	}
}