<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_DependencyInjection
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\DependencyInjection;

use Closure;
use Exception;

/**
 * Service container, responsible for providing
 * services.
 *
 * @package Fonto_DependencyInjection
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Container
{
    /**
     * All services
     *
     * @var array
     */
    protected $services = array();

    /**
     * Core services
     *
     * @var array
     */
    protected $core = array();

    /**
     * Dependency file
     *
     * @var string
     */
    private $coreDependenciesFile = 'Dependencies.php';

    /**
     * User services
     *
     * @var string
     */
    private $userProvided = 'services.php';

    /**
     * Constructor
     *
     * Sets all services, both core and user defined
     */
    public function __construct()
    {
        $core = require __DIR__ . "/{$this->coreDependenciesFile}";
        $this->services = $this->services + $core;
        $this->core = $core;
        unset($core);

        $di = $this;
        $user = require APPWEBPATH . "/{$this->userProvided}";
        unset($user);
    }

    /**
     * Adds a service to the container if there already isn't one
     * registered with the same ID
     *
     * @param  $id
     * @param  $value
     * @return void
     * @throws Exception
     */
    public function addService($id, $value)
    {
        if ($this->isRegistered($id)) {
            throw new Exception("The service is already registered in the container");
        }

        $this->services[$id] = $value;
    }

    /**
     * Sets a service
     *
     * @param  $id
     * @param  $value
     * @return void
     */
    public function setService($id, $value)
    {
        $this->services[$id] = $value;
    }

    /**
     * Gets a service
     *
     * @param $id
     * @return bool|Closure
     */
    public function getService($id)
    {
        $id = ucfirst($id);

        // Is it registered?
        if ($this->isRegistered($id)) {
            $service = $this->services[$id];

            // Is it a closure?
            if ($service instanceof Closure) {
                return $service;
            }

            $args = $service['args']; // Dependencies

            $_args = array(); // DependenciesOfDependencies

            if (sizeof($args)) {

                foreach ($args as $named => $class) {

                    // Checks if dependencies has own dependencies
                    if ($this->isRegistered($named)) {

                        $_args['_args'][$named] = $this->services[$named]; // Add

                    }

                }

                $service = $service + $_args;
            }

            return $service;
        }
        return false;
    }

    /**
     * Returns core services
     *
     * @return array|mixed
     */
    public function getCoreServices()
    {
        return $this->core;
    }

    /**
     * If a service is registered return true, false otherwise
     *
     * @param  $id
     * @return bool
     */
    protected function isRegistered($id)
    {
        return isset($this->services[$id]);
    }
}