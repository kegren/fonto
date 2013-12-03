<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_Cache
 * @subpackage  Driver
 * @link        https://github.com/kegren/fonto
 * @version     0.2
 */

namespace Fonto\Cache\Driver;

/**
 * Driver Interface
 *
 * @package     Fonto_Cache
 * @subpackage  Driver
 * @link        https://github.com/kegren/fonto
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 */
interface DriverInterface
{
    /**
     * Stores a value in the cache
     *
     * @param $key
     * @param $value
     * @param int $expire
     * @return mixed
     */
    public function set($key, $value, $expire = 0);

    /**
     * Returns a value from the cache
     *
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * Deletes a value from the cache
     *
     * @param $key
     * @return mixed
     */
    public function delete($key);

    /**
     * Deletes all content in the cache
     *
     * @return mixed
     */
    public function flush();
}
