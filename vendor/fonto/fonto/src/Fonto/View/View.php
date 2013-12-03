<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_View
 * @link     https://github.com/kegren/fonto
 * @version  0.2
 */

namespace Fonto\View;

use Fonto\View\Driver\DriverInterface;
use Fonto\Facade\Config;
use Fonto\Facade\Fonto;

/**
 * Base view class, handles different view drivers.
 *
 * @package Fonto_View
 * @link    https://github.com/kegren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class View
{
    /**
     * Driver interface object
     *
     * @var Driver\DriverInterface
     */
    protected $driver;

    /**
     * Constructor
     */
    public function __construct()
	{
        $this->driver = Fonto::grab(Config::grab('drivers')->get('view'));
    }

    /**
     * Renders a view
     *
     * @param  string $view
     * @param  array  $data
     * @return void
     */
    public function render($view, $data, $module = null)
    {
        echo $this->driver->render($view, $data, $module);
    }
}