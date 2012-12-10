<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
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