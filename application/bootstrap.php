<?php

/**
 * Include files
 */
include $paths['app'] . 'helpers' . EXT;
include $paths['core'] . 'Application' . EXT;

/**
 * Namespace alias
 */
use Fonto\Core\Application as App;

echo strlen("Add application object and remove unneeded stuff");die;

/**
 * Run application
 */
$app = new App();
$app->run();

unset($paths);