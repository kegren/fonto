<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kegren/fonto
 * @version     0.6
 */

use Fonto\Facade\App;
use HTMLPurifier_Bootstrap as Purifier;

/**
 * Configuration constants
 */
define('START_TIME', microtime(true));
define('DEBUG', false);

function paths()
{
    return array(
        'root' => __DIR__ . '/..',
        'vendor' => __DIR__ . '/../vendor',
        'fontoApp' => __DIR__ . '/../vendor/fonto/fonto/src/Fonto/Application',
        'config' => __DIR__ . '/../config',
        'app' => __DIR__,
        'storage' => __DIR__ . '/storage'
    );
}

function custom()
{
    return array(
        'ds' => DIRECTORY_SEPARATOR,
        'ext' => '.php'
    );
}

($paths = paths() and $custom = custom());

$composerAutoload = function () use ($paths, $custom) {
    return require $paths['vendor'] . '/autoload' . $custom['ext'];
};

$definePaths = function() use ($paths) {
    foreach ($paths as $name => $path) {
        define(strtoupper($name) . 'PATH', $path);
    }
};

($autoload = $composerAutoload() and $definePaths());

/**
 * Sets error reporting
 */
error_reporting(-1);

/**
 * Using HTMLPurifier's own autoloading module
 */
Purifier::registerAutoload();

/**
 * Runs application
 */
App::boot($autoload);

/**
 * Prints out debug info
 */
if (DEBUG) {
    $loadTime = round((microtime(true) - START_TIME), 5);
    printf("Page loading time: %s", $loadTime);
}
