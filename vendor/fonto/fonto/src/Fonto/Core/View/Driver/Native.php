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

use Fonto\Core\View\Driver\DriverInterface;
use Fonto\Core\Application\ObjectHandler;

use Exception;

class Native extends ObjectHandler implements DriverInterface
{
    /**
     * @var string
     */
    protected $extension = '.php';

    /**
     * @var string
     */
    protected $path;

    /**
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
     * @param $view
     */
    public function load($view)
    {
        echo $this->render($view);
    }

    /**
     * Uses purifier
     *
     * @param $data
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
     * @param $view
     * @param array $data
     * @return mixed|string
     */
    public function render($view, $data = array())
    {
        return $this->renderView($view, $data);
    }

    /**
     * Renders a view
     *
     * @param $view
     * @param array $data
     * @return string
     * @throws \Exception
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
            $view = ob_get_contents();
            ob_end_clean();
            return $view;
        } else {
            ob_end_clean();
            throw new Exception("The view file, {$view} wasn't found.");
        }
    }

    /**
     * Checks if a view file exists
     *
     * @param $view
     * @param $path
     * @param $extension
     * @return bool|mixed
     */
    public function findView($view, $path, $extension)
    {
        if (file_exists($path . $view . $extension)) {
            return true;
        }

        return false;
    }

    /**
     * @param $file
     * @return string
     */
    protected function getContent($file)
    {
        return "<pre>" . htmlentities(file_get_contents($file)) . "</pre>";
    }
}