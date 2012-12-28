<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Validation;

use Fonto\Core\Helper\Arr;

class Validator
{
    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @var string
     */
    protected $rulesPrefix = '{}';

    /**
     * @var string
     */
    protected $fieldPrefix = '{field}';

    /**
     * @var string
     */
    protected $valuePrefix = '{value}';

    /**
     * @var array
     */
    protected $validators = array(
        'max' => array(
            'class' => 'Fonto\Core\Validation\Components\ValidateMax',
            'filters' => 'trim',
            'message' => '{field} cant be more than {value} characters.',
            'pattern' => '([a-zA-Z0-9]+)'
        ),
        'min' => array(
            'class' => 'Fonto\Core\Validation\Components\ValidateMin',
            'filters' => 'trim',
            'message' => '{field} most be at least {value} characters',
            'pattern' => '([a-zA-Z0-9]+)'
        ),
        'required' => array(
            'class' => 'Fonto\Core\Validation\Components\ValidateRequired',
            'filters' => 'trim',
            'message' => '{field} is required.',
        ),
        'num' => array(
            'class' => 'Fonto\Core\Validation\Components\ValidateNum',
            'filters' => 'trim',
            'message' => '{field} must be a number.',
            'pattern' => '([0-9]+)'
        ),
        'email' => array(
            'class' => 'Fonto\Core\Validation\Components\ValidateEmail',
            'filters' => 'trim',
            'message' => '{field} is not a valid email address.',
        ),
        'identical' => array(
            'class' => 'Fonto\Core\Validation\Components\ValidateIdentical',
            'filters' => 'trim',
            'message' => '{field} doesn\'t match.',
            'pattern' => '([a-zA-Z0-9]+)'
        ),
        'match' => array(
            'class' => 'Fonto\Core\Validation\Components\ValidateMatch',
            'filters' => 'trim',
            'message' => '{field} doesn\'t match.',
            'pattern' => '([a-zA-Z0-9]+)'
        )
    );

    /**
     * Returns all errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Returns error based on field and type
     *
     * @param  string $field
     * @param  string $type
     * @return mixed
     */
    public function getError($field, $type)
    {
        if (isset($this->errors[$field]) and isset($this->errors[$field][$type])) {
            return $this->errors[$field][$type];
        }

        return false;
    }

    /**
     * Returns error for specified field
     *
     * @param  string $field
     * @return mixed
     */
    public function getErrorFor($field)
    {
        if (isset($this->errors[$field])) {
            $errors = array_keys($this->errors[$field]);
            $return = '';

            foreach ($errors as $error) {
                $return = $this->getError($field, $error);
            }

            return $return;
        }
        return false;
    }

    /**
     * Returns true if there is no errors stored false otherwise
     *
     * @return boolean
     */
    public function isValid()
    {
        return empty($this->errors);
    }

    /**
     * Validates form data against given rules
     *
     * @param array $rules
     * @param array $data
     */
    public function validate(array $rules = array(), array $data = array())
    {
        $valFieldAndRules = array();
        $rulesArr = array();

        foreach ($rules as $field => $rule) {
            $ruleArr = explode('|', $rule);
            $cleanArr = new Arr();
            $ruleArr = $cleanArr->cleanArray($ruleArr);

            foreach ($ruleArr as $rawRule) {
                $fixedRule = $rawRule;
                if ($pos = strpos($rawRule, '{')) {

                    if ($pos > 0) {
                        $fixedRule = substr($rawRule, 0, $pos);
                        $prepareValue = substr($rawRule, $pos);
                        $value = str_replace(array('{', '}'), array('', ''), $prepareValue);
                    }

                    $value = '';
                }

                if (empty($value)) {
                    $rulesArr[$fixedRule] = $fixedRule;
                } else {
                    $rulesArr[$fixedRule] = $value;
                }
            }

            $valFieldAndRules[$field] = $rulesArr;
        }

        foreach ($valFieldAndRules as $field => $value) {
            if (isset($data[$field])) {
                $input = $data[$field];
            }

            foreach ($value as $rule => $val) {
                if (isset($this->validators[$rule])) {

                    $class = $this->validators[$rule]['class'];

                    $validateThis = array(
                        'input' => $input,
                        'value' => ($val == 'username') ? $data['username'] : $val,
                        'field' => $field
                    );

                    $instance = new $class();
                    $message = $instance->validateAttribute($validateThis);

                    if ($message) {
                        $this->errors[$field][$rule] = $message;
                    }

                }
            }

        }
    }

    /**
     * Checks if validator exists
     *
     * @param $key
     * @return boolean
     */
    protected function isDefined($key)
    {
        return array_key_exists($key, $this->validators);
    }
}