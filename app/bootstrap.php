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
include SYSCOREAPPPATH . 'App' . EXT;

/**
 * Namespace alias
 */
use Fonto\Core\Application\App as App;

/**
 * Run application
 */
$app = new App();
$app->setAppName('demo')
	->setActiveRecord(true)
	->setTwig(true)
	->setup()
	->run();