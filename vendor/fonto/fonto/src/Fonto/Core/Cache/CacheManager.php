<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Cache;

class CacheManager
{
    /**
     * @var
     */
    protected $driver;

    /**
     * @var array
     */
    protected $supported = array(
        'memcache' => 'Fonto\Core\Cache\Driver\MemcacheDriver'
    );

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->setOptions($options);
    }

    /**
     * Sets configuration for the cache
     *
     * @param $options
     */
    protected function setOptions($options)
    {
        $this->driver = $options['driver'];

        if (array_key_exists($this->driver, $this->supported)) {
            $this->driver = new $this->supported[$this->driver];
        }
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
