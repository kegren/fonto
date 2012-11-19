<?php
/**
 * Part of Fonto Framework
 *
 * Creates a new application
 */


/**
 * Includes files
 */
include APPPATH . 'helpers' . EXT;
require SYSCOREAPPPATH . 'App' . EXT;

/**
 * Namespaces alias
 */
use Fonto\Core\Application\App as App;

/**
 * Gets main app settings
 *
 * @return array
 */
function appSettings() {
	$appSettings = include __DIR__ . '/config.php';
	return $appSettings;
}

/**
 * Runs application
 */
$app = new App(appSettings());
$app->setup()
	->run();