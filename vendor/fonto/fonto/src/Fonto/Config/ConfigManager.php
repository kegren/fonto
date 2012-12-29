<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Config;

use Fonto\Core\Config\Driver\ConfigInterface;

class ConfigManager
{
    /**
     * @var
     */
    protected $driver;

    /**
     * Supported drivers
     *
     * @var array
     */
    private $supported = array(
        'php' => 'Fonto\Core\Config\Driver\PhpDriver',
        'ini' => 'Fonto\Core\Config\Driver\IniDriver'
    );

    /**
     * @param Driver\ConfigInterface $driver
     */
    public function __construct(ConfigInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param $config
     * @return mixed
     */
    public function read($config)
    {
        return $this->driver->read($config);
    }

    /**
     * Checks if the config file is supported
     * by the manager
     *
     * @param $key
     * @return bool
     */
    protected function isSupported($key)
    {
        return isset($this->supported[$key]);
    }

    /**
     * Checks if given key exists in the
     * configuration array
     *
     * @param $key
     * @param $options
     * @return bool
     */
    protected function has($key, $options)
    {
        return array_key_exists($key, $options);
    }
}