<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Application
 * @link     https://github.com/kegren/fonto
 * @version  0.6
 */

namespace Fonto\Application;

use Fonto\DependencyInjection as DI;
use Exception;
use Fonto\DependencyInjection\ServiceLocator;
use Fonto\Facade\Fonto;
use Fonto\Facade\Config;
use Fonto\Facade\Router;
use Fonto\Facade\Response;


/**
 * Front Controller
 *
 * @package Fonto_Application
 * @link    https://github.com/kegren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class App
{
    /**
     * Current Fonto version
     *
     * @var string
     */
    protected $version = '0.6';

    /**
     * Registered modules
     *
     * @var array
     */
    protected $modules = array();

    /**
     * Constructor
     */
    public function __construct()
    {}

    /**
     * Runs the application and dispatches the HTTP request
     *
     * @param $loader
     * @return mixed
     */
    public function boot($loader)
    {
        $this->initialize(); // Initial setup

        // No modules added, @TODO: Fix error
        if (count($this->modules) < 1) {
            return;
        }

        // Only one module just add without loop
        if (count($this->modules) == 1) {
            $loader->add($this->modules[0], APPPATH . '/modules');
        } else {
            foreach ($this->modules as $module) {
                $loader->add($module, APPPATH . '/modules');
            }
        }

        // Grab a new router instance
        $router = Fonto::grab('router');

        if (!$router->match()) {
            return Response::error(404);
        }

        $router->dispatch(); # Dispatch request
    }

    /**
     * Initial setup
     *
     * @return void
     */
    protected function initialize()
    {
        $this->modules = Config::grab('modules', true);

        date_default_timezone_set(Config::grab('app')->get('timezone'));
    }
}
