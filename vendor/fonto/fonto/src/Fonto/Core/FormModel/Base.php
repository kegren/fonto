<?php

namespace Fonto\Core\FormModel;

use Fonto\Core\Validation\Validate;

abstract class Base
{
	public abstract function rules(Validate $validation);
}