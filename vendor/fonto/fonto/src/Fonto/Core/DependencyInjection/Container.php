<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\DependencyInjection;

use Closure;
use Exception;

class Container
{
    /**
     * @var array
     */
    protected $services = array();

    /**
     * @var string
     */
    private $coreDependenciesFile = 'Dependencies.php';

    /**
     * @var string
     */
    private $userProvided = 'services.php';

    /**
     * Constructor
     */
    public function __construct()
    {
        $core = require __DIR__ . "/{$this->coreDependenciesFile}";
        $this->services = $this->services + $core;
        unset($core);
        $user = require APPWEBPATH . "/{$this->userProvided}";
        $this->services = $this->services + $user;
        unset($user);
    }

    /**
     * Adds a service to the container if there already isn't one
     * registered with the same ID
     *
     * @param $id
     * @param $value
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
     * @param $id
     * @param $value
     */
    public function setService($id, $value)
    {
        $this->services[$id] = $value;
    }

    /**
     * @param $id
     * @return bool|Closure
     */
    public function getService($id)
    {
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

                foreach ($args as $_arg) {

                    // Checks if dependencies has own dependencies
                    if ($this->isRegistered($_arg)) {

                        $_args['_args'][$_arg] = $this->services[$_arg]; // Add

                    }

                }

                $service = $service + $_args;
            }

            return $service;
        }
        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    protected function isRegistered($id)
    {
        return isset($this->services[$id]);
    }
}