<?php

namespace Fonto\Core\Validation\Components;

use Fonto\Core\Validation\Validator;

class Max extends Validator
{
	protected $message = 'Värdet är för stort';

	public function __construct($id, $value, $validateValue)
	{
		$this->validateMax($id, $value, $validateValue);
	}

	protected function validateMax($id, $value, $validateValue)
	{
		(strlen($value) > $validateValue) and static::$errors[$id] = array('max' => $this->message);
	}
}