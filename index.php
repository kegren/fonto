<?php

// Error reporting
error_reporting(-1);


/**
 * Define custom constants
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('EXT') or define('EXT', '.php');

/**
 * Define paths
 */
defined('ROOT') or define('ROOT', realpath(__DIR__). DS);
defined('APPPATH') or define('APPPATH', ROOT . 'application' . DS);
defined('VENDORPATH') or define('VENDORPATH', ROOT . 'vendor' . DS);
defined('SYSCOREPATH') or define('SYSCOREPATH', VENDORPATH . 'fonto' . DS . 'src' . DS . 'Fonto' . DS . 'Core' . DS);
defined('WEBPATH') or define('WEBPATH', ROOT . 'web' . DS);
defined('CONTROLLERSPATH') or define('CONTROLLERSPATH', APPPATH . 'controllers' . DS);
defined('MODELSPATH') or define('MODELSPATH', APPPATH . 'models' . DS);
defined('VIEWPATH') or define('VIEWPATH', APPPATH . 'views' . DS);

$paths = array(
	'app'    => APPPATH,
	'core'   => SYSCOREPATH,
	'web'    => WEBPATH,
	'vendor' => VENDORPATH
);

/**
 * Launch bootstrap
 */
include $paths['app'] . 'bootstrap' . EXT;