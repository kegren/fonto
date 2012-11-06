<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Validation;

class Validate
{
	protected $errors;

	public function __construct()
	{
		$this->errors = array();
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function isValid()
	{
		return empty($this->errors) ? true : false;
	}
}