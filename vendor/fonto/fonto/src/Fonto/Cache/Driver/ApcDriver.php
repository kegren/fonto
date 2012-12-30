<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_Cache
 * @subpackage  Driver
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Cache\Driver;

use Fonto\Cache\Driver\DriverInterface;

/**
 * A wrapper for Apc caching.
 *
 * @package     Fonto_Cache
 * @subpackage  Driver
 * @link        https://github.com/kenren/fonto
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 */
class ApcDriver implements DriverInterface
{
    /**
     * Stores a value by key and sets expiration time
     *
     * @param  string  $key
     * @param  string  $value
     * @param  int     $expire
     * @return mixed
     */
    public function set($key, $value, $expire = 0)
    {
        return apc_store($key, $value, $expire);
    }

    /**
     * Gets a value by key
     *
     * @param  $key
     * @return mixed
     */
    public function get($key)
    {
        return apc_fetch($key);
    }

    /**
     * Deletes a value by key
     *
     * @param  $key
     * @return mixed
     */
    public function delete($key)
    {
        return apc_delete($key);
    }

    /**
     * Deletes all values
     *
     * @return mixed
     */
    public function flush()
    {
        return apc_clear_cache('user');
    }
}