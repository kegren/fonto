<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Cache;

use Fonto\Core\Cache\Driver\DriverInterface;

class CacheManager
{
    /**
     * @var Driver\DriverInterface
     */
    protected $driver;

    /**
     * Constructor
     *
     * @param Driver\DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Stores a value in the cache
     *
     * @param $key
     * @param $value
     * @param int $expire
     * @return MemcacheDriver
     */
    public function set($key, $value, $expire = 0)
    {
        $this->driver->set($key, $value, $expire = 0);
    }

    /**
     * Gets a value from the cache
     *
     * @param $key
     * @return bool
     */
    public function get($key)
    {
        return $this->driver->get($key);
    }

    /**
     * Deletes a value from the cache
     *
     * @param $key
     */
    public function delete($key)
    {
        $this->driver->delete($key);
    }

    /**
     * Removes all values from the cache
     */
    public function flush()
    {
        $this->driver->flush();
    }
}
