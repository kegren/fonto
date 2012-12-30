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
use Exception;
use ReflectionClass;

/**
 * Provides a simple way to instantiate objects
 * and services using magical methods.
 *
 * @package Fonto_Application
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class ObjectHandler
{
    /**
     * Objects currently supported by the handler
     *
     * @var array
     */
    protected $objects = array(
        'App' => '\Fonto\Application\App',
        /*'Auth' => '\Fonto\Authenticate\Auth',*/
        'Cache' => '\Fonto\Cache\CacheManager',
        /*'Config' => '\Fonto\Config\ConfigManager',*/
        'Form' => '\Fonto\Form\Form',
        'FormModel' => '\Fonto\FormModel\Base',
        'Arr' => '\Fonto\Helper\Arr',
        'Request' => '\Fonto\Http\Request',
        /*'Response' => '\Fonto\Http\Response',*/
        'Session' => '\Fonto\Http\Session',
        'Url' => '\Fonto\Http\Url',
        /*'Router' => '\Fonto\Routing\Router',*/
        'Hash' => '\Fonto\Security\Hash',
        'Validation' => '\Fonto\Validation\Validator',
        'Html' => '\Fonto\View\Helper\Html',
        /*'View' => '\Fonto\View\View'*/
    );

    /**
     * Dependency injection manager object
     *
     * @var \Fonto\DependencyInjection\Manager
     */
    protected $di;

    /**
     * Constructor
     *
     * Creates a new instance of the dependency injection manager
     */
    public function __construct()
    {
        $this->di = new DI\Manager(new DI\Container(), new DI\Builder());
    }

    /**
     * Magical call method, catches method calls
     * and checks if the called method is a regular object
     * or a service.
     *
     * @param   string    $object
     * @param   array     $args
     * @return  object
     * @throws  Exception
     */
    public function __call($object, $args = array())
    {
        $object = ucfirst($object);
        $service = $this->di->get($object, false);

        if ($service) {
            return $service;
        }

        if (isset($this->objects[$object])) {
            $object = $this->objects[$object];
            $reflection = new ReflectionClass($object);

            if (sizeof($args)) {
                return $reflection->newInstanceArgs($args);
            } else {
                return $reflection->newInstance();
            }
        }

        throw new Exception("The ObjectHandler only supports registered services or core objects of Fonto, the requested object: $object wasn't found");
    }

    /**
     * Returns manager object
     *
     * @return \Fonto\DependencyInjection\Manager
     */
    public function getDi()
    {
        return $this->di;
    }
}