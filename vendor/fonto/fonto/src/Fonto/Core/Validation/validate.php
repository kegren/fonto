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

	protected $name;

	protected $rules;

	protected $attributes;

	public function __construct()
	{
		$this->errors = array();
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function max($max)
	{
		$this->rules[$this->name]['isMax'] = $max;

		return $this;
	}

	public function num($num)
	{
		$this->rules[$this->name]['isNumeric'] = true;

		return $this;
	}

	public function field($name)
	{
		$this->name = $name;

		return $this;
	}

	public function isValid()
	{
		return empty($this->errors) ? true : false;
	}

	public function validate($attributes = array())
	{
		foreach ($attributes as $id => $value) {
			$this->attributes[$id] = $value;
		}

		foreach ($this->attributes as $id => $value) {
			if ($this->isDefined($id)) {
				$this->validator($id, $value, $this->rules[$id]);
				break;
			}
		}
	}

	private function validator($id, $value, $rules)
	{
		unset($rules[$id]);

		foreach ($rules as $method => $validateValue) {

			if (method_exists($this, $method)) {
				call_user_func(array($this, $method), $id, $value, $validateValue);
			}

		}
	}

	private function isMax($id, $value, $validateValue)
	{
		if (strlen($value) > $validateValue) {
			$this->errors[$id][0] = 'Värdet är för stort';
		}
	}

	private function isDefined($id)
	{
		return array_key_exists($id, $this->rules);
	}

	private function isNumeric($id, $value, $validateValue)
	{
		if (!is_numeric($value)) {
			$this->errors[$id][1] = 'Värdet måste bestå av endast siffror';
		}
	}

}