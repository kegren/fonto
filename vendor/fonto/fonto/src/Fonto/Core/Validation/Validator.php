<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Validation;

use Fonto\Core\Application\App;

class Validator
{
	public $name;

	public $rules;

	protected $errors;

	protected $message;

	protected $attributes;

	protected $current;

	protected $mapRules = array(
		'max'      => 'Fonto\Core\Validation\Components\ValidateMax',
		'num'      => 'Fonto\Core\Validation\Components\ValidateNum',
		'min'      => 'Fonto\Core\Validation\Components\ValidateMin',
		'require'  => 'Fonto\Core\Validation\Components\ValidateRequire'
	);

	protected $app;

	public function __construct()
	{
		$this->errors = array();
	}

	public function setApp(App $app)
	{
		$this->app = $app;
	}

	public function addError($error = array())
	{
		$this->errors = $error;
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function getError($field, $error)
	{
		if (isset($this->errors[$field]) and isset($this->errors[$field][$error])) {
			return $this->errors[$field][$error];
		}

		return false;
	}

	public function getErrorFor($field)
	{
		if (isset($this->errors[$field])) {
			return $this->errors[$field];
		}

		return false;
	}

	public function max($max)
	{
		$this->rules[$this->current]['max'] = $max;

		return $this;
	}

	public function num()
	{
		$this->rules[$this->current]['num'] = true;

		return $this;
	}

	public function min($min)
	{
		$this->rules[$this->current]['min'] = $min;

		return $this;
	}

	public function required()
	{
		$this->rules[$this->current]['require'] = true;

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

	protected function validator($id, $value, $rules)
	{
		foreach ($rules as $method => $validateValue) {
			if (array_key_exists($method, $this->mapRules)) {
				$class = new $this->mapRules[$method]($this->app, $value, $validateValue);
				$errors = $class->getErrorMessage();

				if ($errors) {
					$this->errors[$id][$method] = $class->getErrorMessage();
				}
			}
		}
	}

	protected function isDefined($id)
	{
		return array_key_exists($id, $this->rules);
	}
}