<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Cache\Driver;

use Fonto\Core\Cache\DriverInterface;

use Memcache;

class MemcachedDriver implements DriverInterface
{
    protected $memcache;

    protected $servers = array(
        'default' => array(
            'host' => '127.0.0.1',
            'port' => '11211'
        )
    );

    public function __construct()
    {
        if (false === $this->checkIfMemcacheIsAvailable()) {
            throw new \Fonto\Core\FontoException("{memcache} doesn't appears to be loaded, please check your settings");
        }

        $default = $this->servers['default'];

        $this->memcache = new \Memcached();
        $this->memcache->connect(
            $default['host'],
            $default['port']
        );
    }

    public function set($key, $value, $expire = 0)
    {
        $this->memcache->set($key, $value, MEMCACHE_COMPRESSED, $expire);
        return $this;
    }

    public function get($key)
    {
        return ($this->memcache->get($key)) ?: false;
    }

    protected function checkIfMemcacheIsAvailable()
    {
         return extension_loaded('memcache');
    }
}