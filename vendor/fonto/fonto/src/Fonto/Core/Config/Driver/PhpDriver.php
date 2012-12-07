<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Config\Driver;

use Fonto\Core\Config\Base;
use Fonto\Core\Config\Driver\DriverInterface;

class PhpDriver
{
    const DELIMITER = '#';

    /**
     * @var array
     */
    protected $path;

    /**
     * @var string
     */
    protected $extension = '.php';

    /**
     * Constructor
     */
    public function __construct()
    {}

    /**
     * Loads a config file
     *
     * @param array $options
     * @return mixed
     */
    public function read($config)
    {
        $file = $config;
        $key = '';

        if (strpos($config, self::DELIMITER)) {
            $config = strtolower($config);
            $args = explode(self::DELIMITER, $config);
            $file = isset($args[0]) ? $args[0] : '';
            unset($args[0]); // Remove file
            $key = isset($args[1]) ? $args[1] : '';
        }

        $configArray = $this->getFile($file);

        if ($configArray) {
            if ($key) {
                return $configArray[$key];
            } else {
                return $configArray;
            }
        }

        throw new \Fonto\Core\FontoException("No file with name file was found.");
    }

    /**
     * @param $file
     * @return bool|mixed
     */
    protected function getFile($file)
    {
        $this->path = VIEWPATH;
        $file = $this->path . $file . $this->extension;

        if (file_exists($file)) {
            return include $file;
        } else {
            return false;
        }
    }
}

$config = new \Fonto\Core\Config\Driver\PhpDriver();
$config->read('app#timezone');
