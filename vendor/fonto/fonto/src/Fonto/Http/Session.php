<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Http
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\Http;

/**
 * A wrapper for PHP sessions.
 *
 * @package Fonto_Http
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Session
{
	/**
	 * Constructor
     *
     * Sets path and starts session with provided name
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

    /**
     * Starts session
     *
     * @return bool
     */
    public function start()
    {
        return session_start();
    }

    /**
     * Returns session id if session is started
     *
     * @return string
     */
    public function isStarted()
    {
        return session_id();
    }

    /**
     * Sets a session name
     *
     * @param null $name
     */
    public function setName($name = null)
    {
        session_name(($name) ?: 'FontoMVC');
    }

    /**
     * Sets session save path
     *
     * @param null $path
     */
    public function setSessionSavePath($path = null)
    {
        session_save_path(($path) ?: SESSPATH);
    }

	/**
	 * Saves a value
	 *
	 * @param  string  $id
	 * @param  string  $value
     * @return Session
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
	 * Checks if a session variable is set
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
     * Regenerates session id
     *
     * @return Session
     */
    public function regenerateId()
	{
		session_regenerate_id(true);

		return $this;
	}

    /**
     * Unsets a session variable and then returns it from
     * a local variable. It's used to show flash messages.
     *
     * @param  string $id
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
     * @param  string   $id
     * @return Session
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