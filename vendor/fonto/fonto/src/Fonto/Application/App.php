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

            if (!$modules = modules() and count(modules()) == 0) {
                return;
                #return $this->response()->error(500);
            }

            if (count($modules) == 1) {
                $loader->add($modules[0], APPPATH . 'modules');
            } else {
                foreach ($modules as $module) {
                    $loader->add($module, APPPATH . 'modules');
                }
            }

            $config = $this->config();
            $this->setTimezone($config->read('app#timezone'));

            $router = $this->router();
            $matched = $router->match();

            if (false === $matched) {
                return $this->response()->error(404);
            }

            $dispatcher = $router->dispatch(); // Dispatches request

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
}
