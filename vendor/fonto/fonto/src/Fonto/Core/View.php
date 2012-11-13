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
	 * File extension
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
	 * Adding view and data for the output
	 *
	 * @param string $file
	 * @param array  $data
	 */
	public function __construct()
	{}

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
	 * Set data for view
	 *
	 * @param array $data
	 */
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

	/**
	 * Renders a view
	 *
	 * @param  string $view Viewfile
	 * @param  array  $data Data
	 */
	public function render($view, $data = null)
	{
		$twig = $this->app->getConfig()->load('app', 'twig');

		if ($twig) {
			$this->setExtension('twig');
			$this->view = $view . $this->getExtension();

			if (null === $data) {
				echo $this->app->getTwig()->render($this->view, $this->getData());
			} else {
				echo $this->app->getTwig()->render($this->view, $data);
			}
		} else {
            $this->setExtension('php');

            echo $this->show($view, $data);
        }
	}

	/**
	 * Sets up a view for native php
	 *
	 * @param  string $view Viewfile
	 * @param  array  $data Data
	 * @return mixed
	 */
	public function show($view, $data = null)
	{
	    null === $data and $data = $this->data;
        ob_start() and extract($data, EXTR_OVERWRITE);

        try {
            require VIEWPATH . $view . $this->getExtension();
        }
        catch (\FontoException $e) {
            ob_end_clean();
            throw $e;
        }

        return ob_get_clean();
	}

	/**
	 * Sets extension for the view file
	 *
	 * @param string $type
	 */
	public function setExtension($type)
	{
		switch ($type) {
			case 'twig':
				$this->extension = '.html.twig';
				break;

            case 'php':
                $this->extension = '.php';
                break;

			default:
				$this->extension = '.html';
				break;
		}
	}

	/**
	 * Returns current file extension
	 *
	 * @return string
	 */
	public function getExtension()
	{
		return $this->extension;
	}
}