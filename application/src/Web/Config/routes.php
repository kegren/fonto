<?php
/**
 * Routes config file
 *
 * Set routing for the application.
 */

/**
 *
 * 'all' = load all methods automatic in the controller
 */
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