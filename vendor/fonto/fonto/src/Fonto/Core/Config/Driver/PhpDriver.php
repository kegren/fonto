<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Config\Driver;

use Fonto\Core\Config\Driver\ConfigInterface;
use Exception;

class PhpDriver implements ConfigInterface
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
     * @param $config
     * @return bool|mixed
     * @throws \Exception
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

        throw new Exception("The file: $file wasn't found.");
    }

    /**
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