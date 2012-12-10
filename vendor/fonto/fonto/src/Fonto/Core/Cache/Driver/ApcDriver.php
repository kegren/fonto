<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Cache\Driver;

use Fonto\Core\Cache\Driver\DriverInterface;

class ApcDriver implements DriverInterface
{
    /**
     * @param $key
     * @param $value
     * @param int $expire
     * @return bool|mixed
     */
    public function set($key, $value, $expire = 0)
    {
        return apc_store($key, $value, $expire);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return apc_fetch($key);
    }

    /**
     * @param $key
     * @return bool|mixed|\string[]
     */
    public function delete($key)
    {
        return apc_delete($key);
    }

    /**
     * @return bool|mixed
     */
    public function flush()
    {
        return apc_clear_cache('user');
    }
}