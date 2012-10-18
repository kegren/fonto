<?php
/**
 * Part of Fonto Framework
 *
 * Creates a new application
 */


/**
 * Include files
 */
include $paths['app'] . 'helpers' . EXT;
include $paths['core'] . 'Application' . EXT;

/**
 * Namespace alias
 */
use Fonto\Core\Application as App;

/**
 * Run application
 */
$app = new App();
$app->run();

unset($paths);