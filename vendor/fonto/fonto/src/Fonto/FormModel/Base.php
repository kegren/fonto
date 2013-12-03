<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_FormModel
 * @link     https://github.com/kegren/fonto
 * @version  0.2
 */

namespace Fonto\FormModel;

/**
 * Base class for form models.
 *
 * @package Fonto_FormModel
 * @link    https://github.com/kegren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
abstract class Base
{
    /**
     * Rules for the form
     *
     * @return mixed
     */
    abstract public function rules();
}
