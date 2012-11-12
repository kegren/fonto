<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Validation\Components;

use Fonto\Core\Validation\Validator;
use Fonto\Core\Application\App;

class ValidateMin extends Validator
{
	public function __construct(App $app, $value, $validateValue)
	{
        $this->message = $app->getConfig()->load('Validation', 'min');
		$this->validateAttribute($value, $validateValue);
	}

	protected function validateAttribute($value, $validateValue)
	{
		return strlen($value) < $validateValue and $this->error = $this->message;
	}

    public function getErrorMessage()
    {
        return !empty($this->error) ? $this->error : false;
    }
}