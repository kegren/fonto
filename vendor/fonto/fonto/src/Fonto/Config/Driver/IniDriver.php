<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_Config
 * @subpackage  Driver
 * @link        https://github.com/kegren/fonto
 * @version     0.6
 */

namespace Fonto\Config\Driver;

use Fonto\Config\Driver\ConfigInterface;

/**
 * Handles ini configuration files
 *
 * @package     Fonto_Config
 * @subpackage  Driver
 * @link        https://github.com/kegren/fonto
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @deprecated  since 0.6
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
