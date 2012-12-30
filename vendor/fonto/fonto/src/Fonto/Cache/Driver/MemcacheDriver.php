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

use Fonto\Cache\DriverInterface;
use Memcache;
use Exception;

/**
 * A wrapper for memcache caching.
 *
 * @package     Fonto_Cache
 * @subpackage  Driver
 * @link        https://github.com/kenren/fonto
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 */
class MemcacheDriver implements DriverInterface
{
    /**
     * Memcache object
     *
     * @var Memcache
     */
    protected $memcache;

    /**
     * Servers used by memcache
     *
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
     *
     * Connects to memcache and stores memcache object
     */
    public function __construct()
    {
        if (false === $this->checkIfMemcacheIsAvailable()) {
            throw new Exception("{memcache} doesn't seem to be supported, please check your settings");
        }

        $default = $this->servers['default'];

        $this->memcache = new Memcache();
        $this->memcache->connect(
            $default['host'],
            $default['port']
        );
    }

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
        return $this->memcache->set($key, $value, MEMCACHE_COMPRESSED, $expire);
    }

    /**
     * Gets a value by key
     *
     * @param  $key
     * @return mixed
     */
    public function get($key)
    {
        return ($this->memcache->get($key)) ?: false;
    }

    /**
     * Deletes a value
     *
     * @param $key
     * @return mixed
     */
    public function delete($key)
    {
        return $this->memcache->delete($key);
    }

    /**
     * Deletes all values
     *
     * @return mixed
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