<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Facade
 * @link     https://github.com/kegren/fonto
 * @version  0.6
 */

namespace Fonto\Facade;
use Fonto\DependencyInjection\ServiceLocator;

class Facade
{
    /**
     * @var array
     */
    private static $objects = array(
        'servicelocator' => 'Fonto\DependencyInjection\ServiceLocator',
    );

    /**
     * Uses the service locator instance and grabs a fresh
     * object.
     *
     * @return object
     */
    public static function get()
    {
        return self::getServiceLocator()->get(static::getFacade());
    }

    /**
     * Returns a service locator instance. Used for creating a new
     * instance.
     *
     * @return [type] [description]
     */
    public static function getServiceLocator()
    {
        return new ServiceLocator();
    }

    /**
     * Catches static calls for the facade. Acts as the manager
     * for our facade.
     *
     * @param  string $method [description]
     * @param  string $args   [description]
     * @return object         [description]
     */
    public static function __callStatic($method, $args)
    {
        return call_user_func_array(array(self::get(), $method), $args);
    }
}
