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

use Exception;

class Request
{
	/**
	 * @var string Request method
	 */
	private $method = 'GET';

	/**
	 * @var string Requested Uri
	 */
	private $requestUri;

	/**
	 * @var string Path for the current script
	 */
	private $scriptName;

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

    public function isGet()
    {
        return $this->method === 'GET';
    }

    /**
     * @return string
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
     * @param $key
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
	 * Returns current script path
	 *
	 * @return string
	 */
	public function getScriptName()
	{
		return $this->scriptName;
	}

	/**
	 * Remove dirname from uri if needed
	 *
	 * @return array uri
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