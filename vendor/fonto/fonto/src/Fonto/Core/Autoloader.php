<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/Fonto
 */

/**
 * Currently not in use!
 */

namespace Fonto\Core;

use Fonto\Core\FontoException;

class Autoloader
{

	/**
	 * Directories to search for namespace
	 *
	 * @var array
	 */
	private $directories = array(
		PACKAGESPATH
	);

	/**
	 * Namespace separator
	 *
	 * @var string
	 */
	private $separator = '\\';

	public function __construct(){}

	/**
	 * Register autoloader
	 *
	 * @return void
	 */
	public function register()
	{
		spl_autoload_register(array($this, 'load'));
	}

	/**
	 * Load classes from filesystem
	 *
	 * @param  string $class
	 * @return mixed
	 */
	private function load($class)
	{
		$class = ltrim($class, '\\');
		$namespace = strripos($class, '\\') ?: false;

		if ($namespace) {
			$file = str_replace(array($this->separator, '_'), '/', $class);

			if (file_exists($file . EXT)) {
				return require $file . EXT;
			}

			foreach ((array) $this->directories as $directory) {
				if (file_exists($directory . $file . EXT)) {
					return require $directory . $file . EXT;
				}
			}
		}

		throw new FontoException(sprintf("%s not found", $class));
	}
}