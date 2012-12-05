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
    '/demo/:action/:num',
    array(
        'mapsTo' => 'demo#index',
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
            'testController1',
            'testController2',
            'testController3'
        ),
        'restful' => true,
    )
);