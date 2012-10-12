<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 */

namespace Fonto\Core;

use Fonto\Core\FontoException;

class Config
{
	const DEFAULT_DIR = "Config/";
	const DEFAULT_EXT = '.php';

	/**
	 * Read config file by name and key optional
	 *
	 * @param  string $file
	 * @param  string $key
	 * @return mixed
	 */
	public static function read($file, $key = null)
	{
		if ($config = self::exists($file)) {

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
	 * Check if config file exists
	 *
	 * @param  string $file
	 * @return file
	 */
	private static function exists($file)
	{
		$file = APPWEBPATH . self::DEFAULT_DIR . $file . self::DEFAULT_EXT;

		if (!file_exists($file) or !is_readable($file)) {
			throw new FontoException("The file $file does not exist or is not readable");
		}

		return $file;
	}
}