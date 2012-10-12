<?php
/**
 * Routes
 *
 * @todo  Fix routing
 */

use Fonto\Core\Route;

return array(
	'/' => array(
		'controller' => 'home',
		'action'     => 'index',
		'all'        => false
	),
	'test' => array(
		'all' => true,
	),
);