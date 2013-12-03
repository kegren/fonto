<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_View
 * @subpackage  Driver
 * @link        https://github.com/kegren/fonto
 * @version     0.2
 */

namespace Fonto\View\Driver;

/**
 * Driver interface
 *
 * @package    Fonto_View
 * @subpackage Driver
 * @link       https://github.com/kegren/fonto
 * @author     Kenny Damgren <kenny.damgren@gmail.com>
 */
interface DriverInterface
{
    /**
     * Uses renderView
     *
     * @param  string $view
     * @param  array  $data
     * @return mixed
     */
    public function render($view, $data = array(), $module = null);

    /**
     * Checks if a view file exists
     *
     * @param  string $view
     * @param  string $path
     * @param  string $extension
     * @return mixed
     */
    public function findView($view, $path, $extension);
}