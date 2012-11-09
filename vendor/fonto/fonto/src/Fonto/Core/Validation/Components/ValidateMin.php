<?php

namespace Fonto\Core\Validation\Components;

use Fonto\Core\Validation\Validator;

class ValidateMin extends Validator
{
	protected $message = 'Värdet är för litet';

	public function __construct($id, $value, $validateValue)
	{
		$this->validateAttribute($id, $value, $validateValue);
	}

	protected function validateAttribute($id, $value, $validateValue)
	{
		return (strlen($value) < $validateValue) and static::$errors[$id]['min'] =  $this->message;
	}
}