<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Application;

use Fonto\Core\Routing\Router;
use Fonto\Core\FontoException;
use ActiveRecord;
use HTMLPurifier as Purifier;
use ArrayAccess;

use Fonto;

class App extends Base
{
    /**
     * @var string
     */
    protected $version = '0.5';

    /**
     * @var App
     */
    protected $app;

    /**
     * @var \Fonto\Core\DI\DIManager
     */
    protected $di;

    public $value;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->app = $this;
        $this->setPaths();

        $this->di = new Fonto\Core\DI\DIManager();

        //$this->setExceptionHandler(array('\Fonto\Core\FontoException', 'handleException'));
    }

    /**
     * Runs the application.
     */
    public function run($settings)
    {
        try {
            $loader = $settings['composerAutoloadInstance'];
            $loader->add(ACTIVE_APP, APPPATH . 'src');

            //$this->getDi()->getService('phpass');

            //die;

            $router = $this->getDi()->getService('router');
            $matched = $router->match();

            if (false === $matched) {
                echo "FEL";
                $response = $this->getDi()->getService('response');
                die;
                //return $response->error(404);
            }

            $this->value = "AIK!";

            $obj = $router->dispatch(); // Dispatch request

            $this->value = "AIK!";

            echo $obj;

        } catch (\Exception $e) {
            echo $e->getMessage() . "<br />" . get_class($e);
        }
    }

    public function getDi()
    {
        return $this->di;
    }

    protected function getApp()
    {
        return $this->app;
    }

    /**
     * Sets custom exception handler
     *
     * @param array $options
     */
    private function setExceptionHandler(array $options = array())
    {
        set_exception_handler($options);
    }

    /**
     * Defines paths based on the application name
     */
    private function setPaths()
    {
        if (!defined('CONFIGPATH')) {
            define('CONFIGPATH', APPPATH . 'src' . DS . ACTIVE_APP . DS . 'Config' . DS);
        }


        if (!defined('APPWEBPATH')) {
            define('APPWEBPATH', APPPATH . 'src' . DS . ACTIVE_APP . DS);
        }

        if (!defined('CTLPATH')) {
            define('CTLPATH', APPPATH . 'src' . DS . ACTIVE_APP . DS . 'Controller' . DS);
        }


        if (!defined('VIEWPATH')) {
            define('VIEWPATH', APPPATH . 'src' . DS . ACTIVE_APP . DS . 'View' . DS);
        }

        if (!defined('SESSPATH')) {
            define('SESSPATH', APPWEBPATH . 'Storage' . DS . 'Session' . DS);
        }


        if (!defined('MODELPATH')) {
            define('MODELPATH', APPPATH . 'src' . DS . ACTIVE_APP . DS . 'Model' . DS);
        }

    }
}