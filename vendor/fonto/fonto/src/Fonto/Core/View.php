<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core;

use Fonto\Core\FontoException;
use	Fonto\Core\DI\Container;
use Fonto\Core\Application\App;

class View
{
	/**
	 * File ending
	 *
	 * @var string
	 */
	private $extension;

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
	 * Fonto\Core\Application\App
	 *
	 * @var object
	 */
	protected $app;

	/**
	 * Adding view and data for the output.
	 *
	 * @param string $file
	 * @param array  $data
	 */
	public function __construct()
	{

	}

	public function setApp(App $app)
	{
		$this->app = $app;

		return $this;
	}

	public function setData(array $data = array())
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * Returns data for the view
	 *
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}

	public function render($view, $data = null)
	{
		$twig =	$this->app->isTwig();

		if ($twig) {
			$this->setExtension('twig');
			$this->view = $view . $this->getExtension();

			if (null === $data) {
				echo $this->app->container['twig']->render($this->view, $this->getData());
			} else {
				echo $this->app->container['twig']->render($this->view, $data);
			}
		}
	}

	public function setExtension($type)
	{
		switch ($type) {
			case 'twig':
				$this->extension = '.html.twig';
				break;

			default:
				$this->extension = '.php';
				break;
		}
	}

	public function getExtension()
	{
		return $this->extension;
	}
}