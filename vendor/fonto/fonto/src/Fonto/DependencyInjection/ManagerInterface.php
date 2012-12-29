<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_DependencyInjection
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\DependencyInjection;

/**
 * Manager Interface
 *
 * @package Fonto_DependencyInjection
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
interface ManagerInterface
{
    /**
     * Adds a service only if there isn't one already registered with that
     * id
     *
     * @param  string $id
     * @param  string $value
     * @return mixed|void
     */
    public function add($id, $value);

    /**
     * Sets a service
     *
     * @param string $id
     * @param string $value
     * @return mixed|void
     */
    public function set($id, $value);

    /**
     * Gets a service
     *
     * @param string $id
     * @param bool   $throwException
     */
    public function get($id, $throwException = true);
}