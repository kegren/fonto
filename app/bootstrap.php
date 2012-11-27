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
$autoloader = include VENDORPATH . 'autoload' . EXT;
require SYSCOREAPPPATH . 'App' . EXT;

/**
 * Gets main app settings
 *
 * @return array
 */
function appOptions()
{
    $appOptions = include __DIR__ . '/config.php';
    return $appOptions;
}

function appConfig()
{
    $appConfig = include CONFIGPATH . 'app.php';
    return $appConfig;
}

/**
 * Sets error reporting
 */
error_reporting(-1);

/**
 * Runs application
 */
$app = new Fonto\Core\Application\App();
$app->run($autoloader);