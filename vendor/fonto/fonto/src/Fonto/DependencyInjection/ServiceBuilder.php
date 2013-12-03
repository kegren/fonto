<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_DependencyInjection
 * @link     https://github.com/kegren/fonto
 * @version  0.2
 */

namespace Fonto\DependencyInjection;

class ServiceBuilder
{
    /**
     * Creates a new object
     *
     * @param  array $object
     * @return mixed
     */
    public function resolveObject(array $object)
    {
        return is_array($object) ? new $object['class']() : null;
    }
}
