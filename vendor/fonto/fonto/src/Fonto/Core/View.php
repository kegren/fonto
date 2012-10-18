<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/Fonto
 */

namespace Fonto\Core;

use Fonto\Core\FontoException,
	Fonto\Core\DI\Container;

class View
{
	/**
	 * File ending
	 *
	 * @var string
	 */
	private $defaultFileEnding = '.html.twig';

	/**
	 * Containing output data for the view
	 *
	 * @var array
	 */
	private $data = array();

	/**
	 * Viewfile
	 *
	 * @var string
	 */
	private $view;

	/**
	 * Adding view and data for the output.
	 *
	 * @param string $file
	 * @param array  $data
	 */
	public function __construct($file, $data = null)
	{
		if (!file_exists(VIEWPATH . $file . $this->defaultFileEnding)) {
			throw new FontoException("View $file does not exists");
		}

		if (!is_null($data) and !is_array($data)) {
			throw new FontoException("The $data most be an array");
		} else {
			$this->data = $data;
		}

		if (is_null($data)) {
			$this->data = array();
		}

		$this->view = $file . $this->defaultFileEnding;

		try {
			$container = new Container;
			$container->add('twig', function () {
				$loader = new \Twig_Loader_Filesystem(VIEWPATH);
      			$twig = new \Twig_Environment($loader);

      			return $twig;
			});

			echo $container->get('twig')->render($this->view, $this->data());

		} catch (FontoException $e) {
			throw $e;
		}
	}

	/**
	 * Returns data for the view
	 *
	 * @return array
	 */
	private function data()
	{
		return (array) $this->data;
	}
}