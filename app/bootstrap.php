<?php
/**
 * Part of Fonto Framework
 *
 * Creates a new application
 */


/**
 * Include files
 */
include APPPATH . 'helpers' . EXT;
require SYSCOREAPPPATH . 'App' . EXT;

/**
 * Namespace alias
 */
use Fonto\Core\Application\App as App;


/**
 * Run application
 */
$app = new App();
$app->setAppName('Demo')
	->setup()
	->run();