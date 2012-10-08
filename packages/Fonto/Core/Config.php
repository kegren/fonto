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
	const DEFAULT_DIR = "config/";
	const DEFAULT_EXT = '.ini';

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
			$content = parse_ini_file($config);

			if (is_null($key))
				return $content;

			if (isset($content[$key]))
				return $content[$key];
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
		$file = APPPATH . self::DEFAULT_DIR . $file . self::DEFAULT_EXT;

		if (!file_exists($file) or !is_readable($file)) {
			throw new FontoException("The file $file does not exist or is not readable");
		}

		return $file;
	}
}