<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_Config
 * @subpackage  Driver
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Config\Driver;

use Fonto\Config\Driver\ConfigInterface;
use Exception;

/**
 * Handles php configuration files
 *
 * @package     Fonto_Config
 * @subpackage  Driver
 * @link        https://github.com/kenren/fonto
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 */
class PhpDriver implements ConfigInterface
{
    const DELIMITER = '#';

    /**
     * Path to where the configuration files being stored
     *
     * @var array
     */
    protected $path;

    /**
     * Extension for this driver
     *
     * @var string
     */
    protected $extension = '.php';

    /**
     * Constructor
     */
    public function __construct()
    {}

    /**
     * Reads a value by key: # delimiter ex: "app#timezone" returns
     * timezone array value from app.php
     *
     * @param  string $config
     * @throws Exception
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
                return isset($configArray[$key]) ? $configArray[$key] : false;
            } else {
                return $configArray;
            }
        }

        throw new Exception("The file: $file wasn't found.");
    }

    /**
     * Returns file if exists, false otherwise
     *
     * @param $file
     * @return bool|mixed
     */
    protected function getFile($file)
    {
        $this->path = CONFIGPATH;
        $file = $this->path . $file . $this->extension;

        if (file_exists($file)) {
            return include $file;
        } else {
            return false;
        }
    }
}