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

use Exception;

/**
 * A Factory
 *
 * @package Fonto_Application
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Factory
{
    public static function create($class, $args = '')
    {
        $reflector = new \ReflectionClass($class);
        $constructor = $reflector->getConstructor();

        if (!$args and count($constructor->getParameters() > 0)) {
            throw new Exception(
                sprintf("The class '%s' has dependencies.", $class)
            );
        }

        if (!$args) {
            return new $class();
        }
    }
}
