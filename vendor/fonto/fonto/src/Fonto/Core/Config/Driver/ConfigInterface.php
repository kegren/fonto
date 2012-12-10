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

interface ConfigInterface
{
    /**
     * @param $config
     * @return mixed
     */
    public function read($config);
}
