<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Validation\Components;

use Fonto\Core\Validation\Validator;

class ValidateEmail extends Validator
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
		$this->rule = $this->validators['email'];
	}

    /**
     * Validates given data
     *
     * @param $data
     * @return bool|mixed
     */
	protected function validateAttribute($data)
	{
		if (!filter_var($data['input'], FILTER_VALIDATE_EMAIL)) {
            $message = $this->rule['message'];
            $message = str_replace(array('{field}', '{value}'), array($data['field'], $data['value']), $message);

            return $message;
		}
		return false;
	}
}