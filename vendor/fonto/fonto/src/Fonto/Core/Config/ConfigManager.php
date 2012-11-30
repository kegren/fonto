<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

use Fonto\Core\Config;

class ConfigManager
{
    protected $driver;

    private $supported = array(
        'php',
        'ini'
    );

    public function __construct(ConfigInterface $driver)
    {
        $this->driver = $driver;
    }

    public function load($file)
    {
        $this->driver->load($file);
    }

    public function getDriverExtension()
    {
        return $this->driver->getExtension();
    }
}
