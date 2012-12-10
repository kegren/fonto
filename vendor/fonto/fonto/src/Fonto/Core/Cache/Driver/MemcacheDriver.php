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

use Fonto\Core\Cache\DriverInterface;

use Memcache;
use Exception;

class MemcacheDriver implements DriverInterface
{
    /**
     * @var \Memcache
     */
    protected $memcache;

    /**
     * @var array
     */
    protected $servers = array(
        'default' => array(
            'host' => '127.0.0.1',
            'port' => '11211'
        )
    );

    /**
     * Constructor
     */
    public function __construct()
    {
        if (false === $this->checkIfMemcacheIsAvailable()) {
            throw new Exception("{memcache} doesn't appears to be loaded, please check your settings");
        }

        $default = $this->servers['default'];

        $this->memcache = new Memcache();
        $this->memcache->connect(
            $default['host'],
            $default['port']
        );
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
        return $this->memcache->set($key, $value, MEMCACHE_COMPRESSED, $expire);
    }

    /**
     * Gets a value from the cache
     *
     * @param $key
     * @return bool
     */
    public function get($key)
    {
        return ($this->memcache->get($key)) ?: false;
    }

    /**
     * Deletes a value from the cache
     *
     * @param $key
     */
    public function delete($key)
    {
        return $this->memcache->delete($key);
    }

    /**
     * Removes all values from the cache
     */
    public function flush()
    {
        return $this->memcache->flush();
    }

    /**
     * Checks if memcache extension is loaded
     *
     * @return bool
     */
    protected function checkIfMemcacheIsAvailable()
    {
         return extension_loaded('memcache');
    }
}