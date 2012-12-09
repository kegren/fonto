<?php

namespace Fonto\Core\DependencyInjection;

return array(
    'Config' => array(
        'class' => '\Fonto\Core\Config\ConfigManager',
        'args' => array(
            'PhpDriver' => '\Fonto\Core\Config\Driver\PhpDriver'
        )
    ),
    'Router' => array(
        'class' => '\Fonto\Core\Routing\Router',
        'args' => array(
            'Route' => '\Fonto\Core\Routing\Route',
            'Request' => '\Fonto\Core\Http\Request'
        )
    ),
    'Response' => array(
        'class' => '\Fonto\Core\Http\Response',
        'args' => array(
            'Url' => '\Fonto\Core\Url'
        )
    )
);