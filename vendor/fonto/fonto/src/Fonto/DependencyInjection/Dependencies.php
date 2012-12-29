<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

return array(
    /**
     * Configuration class
     */
    'Config' => array(
        'class' => '\Fonto\Core\Config\ConfigManager',
        'id' => 'Config',
        'args' => array(
            'PhpDriver' => '\Fonto\Core\Config\Driver\PhpDriver'
        )
    ),

    /**
     * Router class
     */
    'Router' => array(
        'class' => '\Fonto\Core\Routing\Router',
        'id' => 'Router',
        'args' => array(
            'Route' => '\Fonto\Core\Routing\Route',
            'Request' => '\Fonto\Core\Http\Request'
        )
    ),

    /**
     * Response class
     */
    'Response' => array(
        'class' => '\Fonto\Core\Http\Response',
        'id' => 'Response',
        'args' => array(
            'Url' => '\Fonto\Core\Http\Url',
            'View' => '\Fonto\Core\View\View',
            'Session' => '\Fonto\Core\Http\Session'
        )
    ),

    /**
     * View class
     */
    'View' => array(
        'class' => '\Fonto\Core\View\View',
        'id' => 'View',
        'args' => array(
            'Native' => '\Fonto\Core\View\Driver\Native'
        )
    ),

    /**
     * Auth class
     */
    'Auth' => array(
        'class' => '\Fonto\Core\Authentication\Auth',
        'id'    => 'Auth',
        'args'  => array(
            'Session' => '\Fonto\Core\Http\Session',
            'Hash' => '\Fonto\Core\Security\Hash'
        )
    )
);