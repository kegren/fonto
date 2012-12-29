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

/**
 * Config Interface
 *
 * @package     Fonto_Config
 * @subpackage  Driver
 * @link        https://github.com/kenren/fonto
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 */
interface ConfigInterface
{
    /**
     * Reads a value by key: # delimiter ex: "app#timezone" returns
     * timezone array value from app.php
     *
     * @param  string $config
     * @return mixed
     */
    public function read($config);
}
