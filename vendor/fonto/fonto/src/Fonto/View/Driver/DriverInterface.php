<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\View\Driver;

interface DriverInterface
{
    /**
     * Renders a view with data
     *
     * @param $view
     * @param array $data
     * @return mixed
     */
    public function render($view, $data = array());

    /**
     * Searches for a view, returns boolean
     *
     * @param $view
     * @param $path
     * @param $extension
     * @return mixed
     */
    public function findView($view, $path, $extension);
}