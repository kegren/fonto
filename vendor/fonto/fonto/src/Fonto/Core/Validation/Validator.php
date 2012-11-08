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
	public $errors;

	public $name;

	public $rules;

	protected $attributes;

	protected $current;

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
		$this->rules[$this->current]['isMax'] = $max;

		return $this;
	}

	public function num()
	{
		$this->rules[$this->current]['isNumeric'] = true;

		return $this;
	}

	public function required()
	{
		$this->rules[$this->current]['isRequired'] = true;

		return $this;
	}

	public function field($name)
	{
		$this->name[$name] = $name;
		$this->current = $name;

		return $this;
	}

	public function isValid()
	{
		return empty($this->errors);
	}

	public function validate($attributes = array())
	{
		foreach ($attributes as $id => $value) {
			$this->attributes[$id] = $value;
		}

		foreach ($this->attributes as $id => $value) {
			if ($this->isDefined($id)) {
				$this->validator($id, $value, $this->rules[$id]);
			}
		}
	}

	private function validator($id, $value, $rules)
	{
		foreach ($rules as $method => $validateValue) {

			if (method_exists($this, $method)) {
				call_user_func(array($this, $method), $id, $value, $validateValue);
			}

		}
	}

	private function isDefined($id)
	{
		return array_key_exists($id, $this->rules);
	}

	private function isMax($id, $value, $validateValue)
	{
		if (strlen($value) > $validateValue) {
			$this->errors[$id]['max'] = 'Värdet är för stort';
		}
	}

	private function isNumeric($id, $value, $validateValue)
	{
		if (!is_numeric($value)) {
			$this->errors[$id]['numeric'] = 'Värdet måste bestå av endast siffror';
		}
	}

	private function isRequired($id, $value, $validateValue)
	{
		return strlen($value) == 0 and $this->errors[$id]['required'] = 'Du måste ange ett värde';
	}

}