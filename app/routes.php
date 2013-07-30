<?php
/**
 * Part of Fonto Framework
 *
 * Sets routing for the application.
 */

/**
 * Registers a default route
 */
$router->addRoute(
    '/',
    array(
        'mapsTo' => 'home#index',
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
