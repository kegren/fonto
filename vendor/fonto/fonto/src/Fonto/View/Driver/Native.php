<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_View
 * @subpackage  Driver
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\View\Driver;

use Fonto\View\Driver\DriverInterface;
use Fonto\Application\ObjectHandler;

use Exception;

/**
 * PHP based view helper.
 *
 * Extends ObjectHandler and implements DriverInterface.
 *
 * @package    Fonto_View
 * @subpackage Driver
 * @link       https://github.com/kenren/fonto
 * @author     Kenny Damgren <kenny.damgren@gmail.com>
 */
class Native extends ObjectHandler implements DriverInterface
{
    /**
     * Extension for this driver
     *
     * @var string
     */
    protected $extension = '.php';

    /**
     * Searchable path
     *
     * @var string
     */
    protected $path;

    /**
     * Data
     *
     * @var array
     */
    protected $data = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->path = VIEWPATH;
    }

    /**
     * Loads a view
     *
     * @param  string $view
     * @return void
     */
    public function load($view)
    {
        echo $this->render($view);
    }

    /**
     * Cleans user data with purifier. Returns cleaned data
     *
     * @param  string $data
     * @return mixed
     */
    public function purify($data)
    {
        $purifier = $this->purifier();
        return $purifier->purify($data);
    }

    /**
     * Uses renderView
     *
     * @param  string $view
     * @param  array  $data
     * @return mixed
     */
    public function render($view, $data = array())
    {
        return $this->renderView($view, $data);
    }

    /**
     * Renders a view and extract its data
     *
     * @param  string $view
     * @param  array  $data
     * @return mixed
     * @throws Exception
     */
    public function renderView($view, $data = array())
    {
        $view = strtolower($view);
        ob_start(); // Start output buffering

        if (!empty($data)) {
            extract($data);
            unset($data); // Remove from local
        }

        if ($this->findView($view, $this->path, $this->extension)) {
            require $this->path . $view . $this->extension;
            $view = ob_get_clean(); // Get buffer and clear it
            return $view;
        } else {
            ob_end_clean();
            throw new Exception("The view file, {$view} wasn't found.");
        }
    }

    /**
     * Checks if a view file exists
     *
     * @param  string $view
     * @param  string $path
     * @param  string $extension
     * @return mixed
     */
    public function findView($view, $path, $extension)
    {
        if (file_exists($path . $view . $extension)) {
            return true;
        }

        return false;
    }

    /**
     * Returns formatted source of a file
     *
     * @param  string $file
     * @return string
     */
    protected function getContent($file)
    {
        return "<pre>" . htmlentities(file_get_contents($file)) . "</pre>";
    }
}