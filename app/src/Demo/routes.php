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
        'restful' => true
    )
);

/**
 * Registers controllers
 */
$router->addRoute(
    '<:controller>',
    array(
        'mapsTo' => array(
            'home' => array(
                'restful' => true
            )
        ),
    )
);