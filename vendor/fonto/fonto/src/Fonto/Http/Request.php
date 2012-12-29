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
 * Request class handles different types of requests inside
 * the framework.
 *
 * @package Fonto_Http
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Request
{
	/**
     * Requested method
     *
	 * @var string
	 */
	private $method = 'GET';

	/**
     * Requested uri
     *
	 * @var string
	 */
	private $requestUri;

	/**
     * Script name
     *
	 * @var string
	 */
	private $scriptName;

    /**
     * Constructor
     */
    public function __construct()
	{
		if (isset($_SERVER['REQUEST_METHOD'])) {
			$this->method = $_SERVER['REQUEST_METHOD'];
		}
		if (isset($_SERVER['REQUEST_URI'])) {
			$this->requestUri = $_SERVER['REQUEST_URI'];
		}
		if (isset($_SERVER['SCRIPT_NAME'])) {
			$this->scriptName = $_SERVER['SCRIPT_NAME'];
		}
	}

	/**
	 * Returns current method
	 *
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * Returns true if the current method is post
	 *
	 * @return boolean
	 */
	public function isPost()
	{
		return $this->method === 'POST';
	}

    /**
     * Returns true if the current method is get
     *
     * @return boolean
     */
    public function isGet()
    {
        return $this->method === 'GET';
    }

    /**
     * Returns all post or get parameters
     *
     * @return array
     */
    public function getParameters()
	{
        if ($this->isPost()) {
            return $_POST;
        }

        if ($this->isGet()) {
            return $_GET;
        }

		return false;
	}

    /**
     * Returns specific parameter if set else empty
     *
     * @param  string $key
     * @return string
     */
    public function getParameter($key)
	{
        if ($this->isPost()) {
            return isset($_POST[$key]) ? $_POST[$key] : '';
        }

        if ($this->isGet()) {
            return isset($_GET[$key]) ? $_GET[$key] : '';
        }


        return false;
	}

	/**
	 * Returns requested uri
	 *
	 * @return array uri
	 */
	public function getRequestUri()
	{
		$uri = $this->parseRequestUri();
		return $uri;
	}

	/**
	 * Returns current script name
	 *
	 * @return string
	 */
	public function getScriptName()
	{
		return $this->scriptName;
	}

    /**
     * Sets up requested uri and removes directory name
     * if necessary
     *
     * @return string
     */
    private function parseRequestUri()
	{
		$uri = $this->requestUri;

		if (strpos($uri, dirname($this->scriptName)) === 0) {
			$uri = substr($uri, strlen(dirname($this->scriptName)));
		}

		return $uri;
	}
}