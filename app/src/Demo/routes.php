<?php
/**
 * Part of Fonto Framework
 *
 * Set routing for the application.
 */

use Fonto\Core\Application\App;

/**
 * Routing
 *
 * <code>
 * // Register controllers
 * $app->addRoute('<:controller>', ('demo'));
 * </code>
 *
 * <code>
 * // Register '/', uses home controller and index method
 * $app->addRoute('/' , 'home#index')
 *
 * // Register '/auth/anything'
 * $app->addRoute('/auth/(:action)', 'auth#index');
 *
 * // Register '/users/show/10'
 * $app->addRoute('/users/show/(:num)', 'users#show');
 * </code>
 *
 */

return array(
	'routes' => function(App $app) {

		$app->addRoute('/', 'home#index');
		$app->addRoute('/demo/(:action)', 'demo#index');
		$app->addRoute('<:controller>', 'aik');

	},
);