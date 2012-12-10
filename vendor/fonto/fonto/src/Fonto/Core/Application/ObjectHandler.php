<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Application;

use Fonto\Core\DependencyInjection as DI;
use Exception;
use ReflectionClass;

class ObjectHandler
{
    /**
     * @var array
     */
    protected $objects = array(
        'App' => '\Fonto\Core\Application\App',
        'Auth' => '\Fonto\Core\Authenticate\Auth',
        'Cache' => '\Fonto\Core\Cache\CacheManager',
        'Config' => '\Fonto\Core\Config\ConfigManager',
        'Form' => '\Fonto\Core\Form\Form',
        'FormModel' => '\Fonto\Core\FormModel\Base',
        'Arr' => '\Fonto\Core\Helper\Arr',
        'Request' => '\Fonto\Core\Http\Request',
        'Response' => '\Fonto\Core\Http\Response',
        'Session' => '\Fonto\Core\Http\Session',
        'Url' => '\Fonto\Core\Http\Url',
        'Router' => '\Fonto\Core\Routing\Router',
        'Hash' => '\Fonto\Core\Security\Hash',
        'Validation' => '\Fonto\Core\Validation\Validator',
        'View' => '\Fonto\Core\View\View'
    );

    /**
     * @var \Fonto\Core\DependencyInjection\Manager
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