<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_View
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\View;

use Fonto\View\Driver\DriverInterface;

/**
 * Base view class, handles different view drivers.
 *
 * @package Fonto_View
 * @link    https://github.com/kenren/fonto
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
     *
     * @param Driver\DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
	{
        $this->driver = $driver;
    }

    /**
     * Renders a view
     *
     * @param  string $view
     * @param  array  $data
     * @return void
     */
    public function render($view, $data)
    {
        echo $this->driver->render($view, $data);
    }
}