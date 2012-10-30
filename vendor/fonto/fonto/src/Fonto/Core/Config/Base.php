<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Config;

use Fonto\Core\FontoException;

class Base
{
	/**
	 * Path for config directory
	 *
	 * @var string
	 */
	private $path = array();

	protected $app;


	public function __construct(\Fonto\Core\Application\App $app, array $path)
	{
		$this->app = $app;
		$this->path[] = $path;
	}

	/**
	 * Read config file by name and key optional
	 *
	 * @param  string $file
	 * @param  string $key
	 * @return mixed
	 */
	public function get($file, $key = null)
	{
		if ($config = $this->exists($file)) {

			if (is_null($key)) {
				return $config;
			}

			if (isset($config[$key])) {
				return $config[$key];
			}
		}

		return false;
	}

	/**
	 * Check if given config file exists
	 *
	 * @param  string $file
	 * @return file
	 */
	private function exists($file)
	{
		$file = $this->path . $file . EXT;

		if (!file_exists($file) or !is_readable($file)) {
			throw new FontoException("The file $file does not exist or is not readable");
		}

		return include $file;
	}
}