<?php
/**
 * Part of Fonto Framework
 *
 * Application 'specific' settings
 */

 return array(
 	/**
 	 * Default timezone
 	 */
 	'timezone' => 'Europe/Stockholm',

 	/**
 	 * Database settings
 	 */
 	'database' => array(
 		'type' => 'mysql',
 		'host' => 'localhost',
 		'user' => 'root',
 		'pass' => '',
 		'name' => 'fonto',
 	),

 	/**
 	 * Using twig as template language
 	 */
 	'twig' => true,

 	/**
 	 * Application environment, development enables error_reporting
 	 */
 	'environment' => 'development',

 	/**
 	 * Autoload classes in libraries
 	 */
 	'autoload' => false
 );