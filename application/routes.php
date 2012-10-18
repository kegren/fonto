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
 *
 * // Register multi controllers
 * $app->route('<:controller>',array('home', 'auth')); // not finished..
 * </code>
 *
 * <code>
 * // Register '/', route to match home controller and index method
 * $app->route('/' , 'home#index')
 *
 * // Register '/auth/anything' to match test controller and index method
 * $app->route('/auth/(:action)', 'auth#index');
 * </code>
 *
 */

$app->route('/', 'home#index');
$app->route('/hem/(:action)/(:num)', 'lek#index');
$app->route('/auth/(:action)','auth#index');
$app->route('/test/testing/(:num)', 'standard#update');
$app->route('<:controller>', array('home', 'lek'));