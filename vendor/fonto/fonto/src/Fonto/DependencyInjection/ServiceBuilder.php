<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_DependencyInjection
 * @link     https://github.com/kenren/fonto
 * @version  0.6
 */

namespace Fonto\DependencyInjection;

class ServiceBuilder
{
    /**
     * Creates a new object
     *
     * @param  [type] $object [description]
     * @return [type]         [description]
     */
    public function resolveObject($object)
    {
        return is_array($object) ? new $object['class']() : null;
    }
}
