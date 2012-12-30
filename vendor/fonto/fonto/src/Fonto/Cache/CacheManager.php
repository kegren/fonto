<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Cache
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\Cache;

use Fonto\Cache\Driver\DriverInterface;

/**
 * Responsible for managing cache drivers.
 *
 * @package Fonto_Cache
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class CacheManager
{
    /**
     * Driver object
     *
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
     * Stores a value by key and sets expiration time
     *
     * @param  string  $key
     * @param  string  $value
     * @param  int     $expire
     * @return void
     */
    public function set($key, $value, $expire = 0)
    {
        $this->driver->set($key, $value, $expire = 0);
    }

    /**
     * Gets a value by key
     *
     * @param  $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->driver->get($key);
    }

    /**
     * Deletes a value by key
     *
     * @param  $key
     * @return void
     */
    public function delete($key)
    {
        $this->driver->delete($key);
    }

    /**
     * Deletes all values
     *
     * @return void
     */
    public function flush()
    {
        $this->driver->flush();
    }
}
