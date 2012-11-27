<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto_Validation
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Validation\Components;

use Fonto\Core\Validation\Validator;

class ValidateRequired extends Validator
{
    /**
     * @var array
     */
    private $rule = array();

    /**
     * Constructor.
     */
    public function __construct()
	{
        $this->rule = $this->validators['required'];
	}

    /**
     * Validates given data
     *
     * @param $data
     * @return bool|mixed
     */
	protected function validateAttribute($data)
	{
		if (strlen($data['input']) == 0) {
            $message = $this->rule['message'];
            $message = str_replace(array('{field}', '{value}'), array($data['field'], $data['value']), $message);

            return $message;
		}
		return false;
	}
}