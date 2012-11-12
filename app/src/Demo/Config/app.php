<?php
/**
 * Part of Fonto Framework
 *
 * Application settings
 */

 return array(
 	/**
 	 * Sets Default timezone
 	 */
 	'timezone' => 'Europe/Stockholm',

 	/**
 	 * Sets database settings
 	 */
 	'database' => array(
 		'development' => array(
	 		'type' => 'mysql',
	 		'host' => 'localhost',
	 		'user' => 'root',
	 		'pass' => '',
	 		'name' => 'fontomvc'
 		),
 		'production' => array(
	 		'type' => 'mysql',
	 		'host' => 'localhost',
	 		'user' => 'root',
	 		'pass' => '',
	 		'name' => 'fonto'
 		),
 	),

 	/**
 	 * Sets application environment, development enables error_reporting(-1)
 	 */
 	'environment' => 'development',

 	/**
 	 * Sets baseUrl for application
 	 */
 	'baseUrl' => '',

 	/**
 	 * Enables twig
 	 */
 	'twig' => true
 );