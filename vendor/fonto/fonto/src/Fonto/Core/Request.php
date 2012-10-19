<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core;

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
	 * Get current method
	 *
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * Get requested uri
	 *
	 * @return array uri
	 */
	public function getRequestUri()
	{
		$uri = $this->parseRequestUri();
		return $uri;
	}

	/**
	 * Get current script path
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