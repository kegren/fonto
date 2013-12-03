<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_Config
 * @subpackage  Driver
 * @link        https://github.com/kegren/fonto
 * @version     0.2
 */

namespace Fonto\Config\Driver;

/**
 * Config Interface
 *
 * @package     Fonto_Config
 * @subpackage  Driver
 * @link        https://github.com/kegren/fonto
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @deprecated  since 0.2
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
