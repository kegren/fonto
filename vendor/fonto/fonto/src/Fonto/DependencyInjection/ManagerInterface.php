<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\DependencyInjection;

interface ManagerInterface
{
    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function set($id, $value);

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function add($id, $value);

    /**
     * @param $id
     * @return mixed
     */
    public function get($id);
}