<?php
/**
 * Part of Fonto Framework
 *
 * Set routing for the application.
 */

/**
 * Routing
 *
 * <code>
 * // Register multi controllers
 * $app->route('<:controller>',array('home', 'auth')); // not finished..
 * </code>
 *
 * <code>
 * // Register '/', uses home controller and index method
 * $app->route('/' , 'home#index')
 *
 * // Register '/auth/anything'
 * $app->route('/auth/(:action)', 'auth#index');
 *
 * // Register '/users/show/10'
 * $app->route('/users/show/(:num)', 'users#show');
 * </code>
 *
 */

$app->route('/', 'home#index');