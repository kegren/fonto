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

/**
 * Handles ini configuration files
 *
 * @package     Fonto_Config
 * @subpackage  Driver
 * @link        https://github.com/kenren/fonto
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 */
class IniDriver implements ConfigInterface
{
    /**
     * Reads a value by key: # delimiter ex: "app#timezone" returns
     * timezone array value from app.php
     *
     * @param  string $config
     * @throws Exception
     * @return mixed
     */
    public function read($config){}
}
