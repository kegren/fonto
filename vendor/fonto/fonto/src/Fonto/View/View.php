<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\View;

use Fonto\View\Driver\DriverInterface;

class View
{
    /**
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
     * @param $view
     * @param $data
     */
    public function render($view, $data)
    {
        echo $this->driver->render($view, $data);
    }
}