<?php

namespace Fonto\Core\Validation\Components;

use Fonto\Core\Validation\Validator;

class Require extends Validator
{
	protected $message = '';

	public function __construct($id, $value, $validateValue)
	{
		$this->validateAttribute($id, $value, $validateValue);
	}

	protected function validateAttribute($id, $value, $validateValue)
	{
		!is_numeric($value) and static::$errors[$id] = array('require' => $this->message);
	}
}