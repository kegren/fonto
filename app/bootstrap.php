<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

/**
 * Configuration constants
 */
define('START_TIME', microtime(true));
define('DEBUG', true);
define('CACHE', false);
define('ACTIVE_APP', 'Demo');

/**
 * Include files
 */
include APPPATH . 'helpers' . EXT;
$loader = require VENDORPATH . 'autoload' . EXT;
require SYSCOREAPPPATH . 'App' . EXT;

/**
 * Sets error reporting
 */
error_reporting(-1);

/**
 * Registers autoloader for HTMLPurifier component
 */
\HTMLPurifier_Bootstrap::registerAutoload();

/**
 * Runs application
 */
$app = new Fonto\Core\Application\App();
$app->run(
    array(
        'composerAutoloadInstance' => $loader
    )
);

/**
 * Prints out debug info
 */
if (DEBUG) {
    $loadTime = round((microtime(true) - START_TIME), 5);

    printf("Page loading time: %s", $loadTime);
}