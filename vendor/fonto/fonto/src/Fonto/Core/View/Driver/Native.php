<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\View\Driver;

use Fonto\Core\View\Driver\DriverInterface;

class Native implements DriverInterface
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

    public function render($view, $data = array())
    {
        return $this->renderView($view, $data);
    }

    public function renderView($view, $data = array())
    {
        $this->path = VIEWPATH;
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
            throw new \Exception("The view file, {$view$this->extension} wasn't found.");
        }
    }

    public function findView($view, $path, $extension)
    {
        if (file_exists($path . $view . $extension)) {
            return true;
        }

        return false;
    }
}