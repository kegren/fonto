<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Cache;

interface DriverInterface
{
    public function set($key, $value, $expire = 0);

    public function get($key);
}
