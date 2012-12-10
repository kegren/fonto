<?php
/**
 * Part of Fonto Framework
 *
 * Sets routing for the application.
 */

/**
 * Routing system setup
 */

/**
 * Registers a default route
 */
$router->addRoute(
    '/',
    array(
        'mapsTo' => 'home#index',
        'restful' => true,
        'method' => 'get',
    )
);

/**
 * Registers a route
 */
$router->addRoute(
    '/demo/visa/:num',
    array(
        'mapsTo' => 'testController1#index',
        'restful' => false,
    )
);

/**
 * Registers controllers
 */
$router->addRoute(
    '<:controller>',
    array(
        'mapsTo' => array(
            'home',
            'testController2',
            'testController3'
        ),
        'restful' => true,
    )
);