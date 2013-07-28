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

class Facade
{
    public static function __callStatic($name, $args)
    {
        return call_user_func_array(array(self::getInstance(), $method), $args);
    }
}