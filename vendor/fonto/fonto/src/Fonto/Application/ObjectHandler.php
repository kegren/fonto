<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Application;

use Fonto\DependencyInjection as DI;
use Exception;
use ReflectionClass;

class ObjectHandler
{
    /**
     * @var array
     */
    protected $objects = array(
        'App' => '\Fonto\Application\App',
        'Auth' => '\Fonto\Authenticate\Auth',
        'Cache' => '\Fonto\Cache\CacheManager',
        'Config' => '\Fonto\Config\ConfigManager',
        'Form' => '\Fonto\Form\Form',
        'FormModel' => '\Fonto\FormModel\Base',
        'Arr' => '\Fonto\Helper\Arr',
        'Request' => '\Fonto\Http\Request',
        'Response' => '\Fonto\Http\Response',
        'Session' => '\Fonto\Http\Session',
        'Url' => '\Fonto\Http\Url',
        'Router' => '\Fonto\Routing\Router',
        'Hash' => '\Fonto\Security\Hash',
        'Validation' => '\Fonto\Validation\Validator',
        'View' => '\Fonto\View\View'
    );

    /**
     * @var \Fonto\DependencyInjection\Manager
     */
    protected $di;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->di = new DI\Manager(new DI\Container(), new DI\Builder());
    }

    /**
     * @param $id
     * @param $value
     * @throws \Exception
     */
    public function __set($id, $value)
    {
        throw new Exception("You cant set a value in the " . __CLASS__);
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function __get($id)
    {
        throw new Exception("You cant get a regular property in the " . __CLASS__);
    }

    /**
     * Catches method calls
     *
     * @param $object
     * @param array $args
     * @return object
     * @throws \Exception
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
     * @param $object
     * @param array $args
     * @throws \Exception
     */
    public static function __callStatic($object, $args = array())
    {
        throw new Exception("No static call allowed");
    }
}