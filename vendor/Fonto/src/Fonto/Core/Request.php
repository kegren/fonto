<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
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
	private $requestedUri;

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
			$this->requestedUri = $_SERVER['REQUEST_URI'];
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
		return (array) $uri;
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
}