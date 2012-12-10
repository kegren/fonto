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

class ValidateNum extends Validator
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
		$this->rule = $this->validators['num'];
	}

    /**
     * Validates given data
     *
     * @param $data
     * @return bool|mixed
     */
	protected function validateAttribute($data)
	{
		if (!is_numeric($data['input'])) {
            $message = $this->rule['message'];
            $message = str_replace(array('{field}', '{value}'), array($data['field'], $data['value']), $message);

            return $message;
		}
		return false;
	}
}