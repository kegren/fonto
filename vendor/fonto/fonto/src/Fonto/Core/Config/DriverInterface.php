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

interface DriverInterface
{
    public function load(array $options = array());
}
