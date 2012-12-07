<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Config;

use Fonto\Core\Config\Driver\DriverInterface;

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
     * Constructor
     *
     * @param Driver\DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Loads a config file
     *
     * @param $options
     */
    public function load(array $options = array())
    {
        if ($this->has('file', $options)) {
            $fileRaw = $options['file'] ? : null;
            $file = pathinfo($fileRaw, PATHINFO_FILENAME);

            $option = '';

            if ($this->has('option', $options)) {
                $option = $options['option'] ? : null;
            }

            $extension = strtolower(pathinfo($fileRaw, PATHINFO_EXTENSION));

            if ($extension) {
                if ($this->isSupported($extension)) {
                    return $this->driver->load(compact('file', 'option'));
                }

                throw new \Fonto\Core\FontoException("The file {$file} is not supported");
            }

            return $this->driver->load(compact('file', 'option'));
        }

        throw new \Fonto\Core\FontoException("There must be a specified file option");
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