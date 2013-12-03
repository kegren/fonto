<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_Validation
 * @subpackage  Components
 * @link        https://github.com/kegren/fonto
 * @version     0.2
 */

namespace Fonto\Validation\Components;

use Fonto\Validation\Validator;

/**
 * Max validation class.
 *
 * @package    Fonto_Validation
 * @subpackage Components
 * @link       https://github.com/kegren/fonto
 * @author     Kenny Damgren <kenny.damgren@gmail.com>
 */
class ValidateMax extends Validator
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
        $this->rule = $this->validators['max'];

        $input = $options['input'];
        $value = $options['value'];
        $field = $options['field'];
        $message = $options['message'];

        if (strlen($input) > $value) {
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
        return (string)$this->message;
    }

    /**
     * Returns true if there is an error false otherwise
     *
     * @return bool
     */
    public function hasError()
    {
        return (bool)$this->error;
    }
}