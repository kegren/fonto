<?php

/**
 * Include files
 */
include $paths['app'] . 'helpers' . EXT;
include $paths['core'] . 'Application' . EXT;

/**
 * Namespace shortcuts
 */
use Fonto\Core\Application as App;

/**
 * Run application
 */
$app = new App();
$app->run();

unset($paths);