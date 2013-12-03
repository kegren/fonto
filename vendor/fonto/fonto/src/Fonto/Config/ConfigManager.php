<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Config
 * @link     https://github.com/kegren/fonto
 * @version  0.2
 */

namespace Fonto\Config;

use Fonto\Config\Driver\ConfigInterface;

/**
 * Responsible for managing config drivers.
 *
 * @package Fonto_Cache
 * @link    https://github.com/kegren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 * @deprecated since 0.2
 */
class ConfigManager
{
    /**
     * Driver object
     *
     * @var ConfigInterface
     */
    protected $driver;

    /**
     * Supported drivers
     *
     * @var array
     */
    private $supported = array(
        'php' => 'Fonto\Config\Driver\PhpDriver',
        'ini' => 'Fonto\Config\Driver\IniDriver'
    );

    /**
     * Constructor
     *
     * @param Driver\ConfigInterface $driver
     */
    public function __construct(ConfigInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Reads a value by key: # delimiter ex: "app#timezone" returns
     * timezone array value from app.php
     *
     * @param  string $config
     * @return mixed
     */
    public function read($config)
    {
        return $this->driver->read($config);
    }
}