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
use Fonto\Core\Application\App;

class Base
{
	/**
	 * Path for config directory
	 *
	 * @var string
	 */
	private $paths = array();

	/**
	 * Fonto\Core\Application\App
	 *
	 * @var
	 */
	protected $app;


	public function __construct(array $paths)
	{
		$this->paths = $paths;
	}

	/**
	 * Current application
	 *
	 * @param App $app
	 */
	public function setApp(App $app)
	{
		$this->app = $app;

		return $this;
	}

	/**
	 * Read config file by name and key optional
	 *
	 * @param  string $file
	 * @param  string $key
	 * @return mixed
	 */
	public function load($file, $key = null)
	{
		if ($config = $this->findFile($file)) {

			if (is_callable($config[$key])) {
				return $config[$key]($this->app);
			}

			if (isset($config[$key])) {
				return $config[$key];
			}

		}

		throw new FontoException("No file with name $file was found");
	}

	/**
	 * Check if given config file exists
	 *
	 * @param  string $file
	 * @return file
	 */
	private function findFile($file)
	{
		foreach ($this->paths as $path) {
			$config = $path . $file . EXT;

			if (file_exists($config)) {
				return require $config;
			}
		}
	}
}