<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Application
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\Application;

use Fonto\DependencyInjection as DI;
use Fonto\Application\ObjectHandler;
use Exception;

/**
 * Front Controller
 *
 * @package Fonto_Application
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class App extends ObjectHandler
{
    /**
     * Current Fonto version
     *
     * @var string
     */
    protected $version = '0.5';

    /**
     * Constructor
     *
     * Sets up paths
     */
    public function __construct()
    {
        $this->setPaths();
        parent::__construct();
    }

    /**
     * Runs the application and dispatches the HTTP request
     *
     * @param $loader
     * @return mixed
     */
    public function run($loader)
    {
        try {
            $loader->add(ACTIVE_APP, APPPATH . 'src');

            $config = $this->config();
            $this->setTimezone($config->read('app#timezone'));

            $router = $this->router();
            $matched = $router->match();

            if (false === $matched) {
                return $this->response()->error(404);
            }

            $dispatcher = $router->dispatch(); // Dispatch request

            if (false === $dispatcher) {
                return $this->response()->error(404);
            }

        } catch (Exception $e) {
            echo $e->getMessage() . " " . $e->getLine();
        }
    }

    /**
     * Sets the timezone
     *
     * @param $timezone
     */
    protected function setTimezone($timezone)
    {
        date_default_timezone_set($timezone);
    }

    /**
     * Defines paths based on the application name
     *
     * @return void
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