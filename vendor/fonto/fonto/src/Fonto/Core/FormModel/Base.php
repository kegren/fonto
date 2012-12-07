<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto_FormModel
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\FormModel;

abstract class Base
{
    /**
     * Rules for the form
     *
     * @return
     */
	public abstract function rules();
}