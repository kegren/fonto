<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_DependencyInjection
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

return array(
    /**
     * Configuration class
     */
    'Config' => array(
        'class' => '\Fonto\Config\ConfigManager',
        'id' => 'Config',
        'args' => array(
            'PhpDriver' => '\Fonto\Config\Driver\PhpDriver'
        )
    ),
    /**
     * Router class
     */
    'Router' => array(
        'class' => '\Fonto\Routing\Router',
        'id' => 'Router',
        'args' => array(
            'Route' => '\Fonto\Routing\Route',
            'Request' => '\Fonto\Http\Request'
        )
    ),
    /**
     * Response class
     */
    'Response' => array(
        'class' => '\Fonto\Http\Response',
        'id' => 'Response',
        'args' => array(
            'Url' => '\Fonto\Http\Url',
            'View' => '\Fonto\View\View',
            'Session' => '\Fonto\Http\Session'
        )
    ),
    /**
     * View class
     */
    'View' => array(
        'class' => '\Fonto\View\View',
        'id' => 'View',
        'args' => array(
            'Native' => '\Fonto\View\Driver\Native'
        )
    ),
    /**
     * Auth class
     */
    'Auth' => array(
        'class' => '\Fonto\Authentication\Auth',
        'id' => 'Auth',
        'args' => array(
            'Session' => '\Fonto\Http\Session',
            'Hash' => '\Fonto\Security\Hash'
        )
    )
);