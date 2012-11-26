<?php
/**
 * Part of Fonto Framework
 *
 * Sets routing for the application.
 */

/**
 * Routing
 *
 * <code>
 * // Registers controllers
 * $app->addRoute('<:controller>', 'demo');
 * </code>
 *
 * <code>
 * // Registers '/', uses home controller and index method
 * $app->addRoute('/' , 'home#index')
 *
 * // Registers '/auth/anything'
 * $app->addRoute('/auth/(:action)', 'auth#index');
 *
 * // Registers '/users/show/num'
 * $app->addRoute('/users/show/(:num)', 'users#show');
 * </code>
 *
 */

return array(
    'routes' => array(
        '/' => 'home#index',
        '/demo/(:action)' => 'home#index'
    )
);