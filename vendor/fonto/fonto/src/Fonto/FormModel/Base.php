<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_FormModel
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\FormModel;

/**
 * Base class for form models.
 *
 * @package Fonto_FormModel
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
abstract class Base
{
    /**
     * Rules for the form
     *
     * @return mixed
     */
	public abstract function rules();
}