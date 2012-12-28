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
     * Returns error for specified field
     *
     * @param  string $field
     * @return mixed
     */
    public function getError($field)
    {
        if (isset($this->errors[$field])) {

            return reset($this->errors[$field]);
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
     * @param array $inputData
     * @internal param array $data
     * @return bool
     */
    public function validate(array $rules = array(), array $inputData = array())
    {
        $matchedRules = array(); // Hold matched rules
        $fixedRules = array();
        $arrayHelper = new \Fonto\Core\Helper\Arr(); // For triming and removal of empty values
        $inputData = $arrayHelper->trimArray($inputData);

        // Begin by checking if there is a rule set for a field
        foreach ($rules as $field => $options) {
            if (isset($inputData[$field])) {
                $matchedRules[$field] = $options;
            }
        }

        // No matching rules defined, return false
        if (sizeof($matchedRules) == 0) {
            return false;
        }

        // Loop through defined rules
        foreach ($matchedRules as $field => $options) {
            if (!isset($options['rules']) and !isset($options['message'])) {
                break;
            }
            $rules = isset($options['rules']) ? $options['rules'] : '';
            $message = isset($options['messages']) ? $options['messages'] : '';

            // Make sure that rules is not an empty string
            if (!empty($rules)) {
                $rules = explode('|', $rules);
                $rules = $arrayHelper->cleanArray($rules); // Remove empty elements

                if (sizeof($rules)) {
                    $temporaryRulesArray = array();
                    foreach ($rules as $rule) {
                        $matches = array();
                        $ruleValue = null;
                        preg_match('/{([^}]*)}/', $rule, $matches); // Grabs value between {}

                        if (sizeof($matches)) {
                            $removeExpression = isset($matches[0]) ? $matches[0] : ''; // Get returned expression
                            $ruleValue = isset($matches[1]) ? $matches[1] : '';
                            $rule = substr($rule, 0, strpos($rule, $removeExpression));
                            unset($removeExpression); // Remove unnecessary var
                        }

                        $temporaryRulesArray[$rule] = isset($ruleValue) ? $ruleValue : $rule;
                    }

                    $fixedRules[$field] = array(
                        'rules' => $temporaryRulesArray,
                        'message' => $message
                    );
                }
            } else {
                return false;
            }
        }

        // Finally ready to ..
        foreach ($fixedRules as $field => $option) {

            $input = $inputData[$field]; // Get matching input data
            $rules = isset($option['rules']) ? $option['rules'] : array();

            if (!sizeof($rules)) {
                return false;
            }

            // Loop through rules by name and value
            foreach ($rules as $rule => $value) {

                if (!isset($this->validators[$rule])) {
                    continue; // Skip
                }

                $class = $this->validators[$rule]['class']; // Defined class in validators array
                $message = $fixedRules[$field]['message']; // Always set
                $message = isset($message[$rule]) ? $message[$rule] : '';

                $object = new $class(array(
                    'input' => $input,
                    'value' => ($rule == 'identical') ? $inputData[$value] : $value,
                    'field' => $field,
                    'message' => $message
                ));

                // Any error?
                if ($object->hasError()) {
                    $this->errors[$field][$rule] = $object->getMessage();
                }

            }

        }

        return true;
    }
}