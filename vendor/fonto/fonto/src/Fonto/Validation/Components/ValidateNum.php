<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_Validation
 * @subpackage  Components
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Validation\Components;

use Fonto\Validation\Validator;

/**
 * Num validation class.
 *
 * @package    Fonto_Validation
 * @subpackage Components
 * @link       https://github.com/kenren/fonto
 * @author     Kenny Damgren <kenny.damgren@gmail.com>
 */
class ValidateNum extends Validator
{
    /**
     * Rule
     *
     * @var array
     */
    protected $rule = array();

    /**
     * Error message
     *
     * @var
     */
    protected $message;

    /**
     * Flag for error
     *
     * @var bool
     */
    protected $error = false;

    /**
     * Constructor
     */
    public function __construct($options = array())
    {
        $this->rule = $this->validators['num'];

        $input = $options['input'];
        $value = $options['value'];
        $field = $options['field'];
        $message = $options['message'];

        if (!is_numeric($input)) {
            $this->error = true;

            if (!$message) {
                $this->message = $this->rule['message'];
                $this->message = str_replace(array('{field}', '{value}'), array($field, $value), $this->message);
            } else {
                $this->message = $message;
            }
        }
    }

    /**
     * Returns message
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Returns true if there is an error false otherwise
     *
     * @return bool
     */
    public function hasError()
    {
        return $this->error;
    }
}