<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 */

namespace Fonto\Core;

use Fonto\Core\FontoException;

class View
{
	/**
	 * Default files
	 *
	 * @var string
	 */
	private $defaultFileEnding = '.php';

	/**
	 * Containing output data for the view
	 *
	 * @var array
	 */
	private $data = array();

	/**
	 * The view to show
	 *
	 * @var [type]
	 */
	private $view;

	/**
	 * Set the view file and the data
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

		$this->view = $file;

		echo $this->get();
	}

	public function get()
	{
		extract($this->data);

		ob_start();

		require VIEWPATH . $this->view . $this->defaultFileEnding;

		return ob_get_clean();
	}
}