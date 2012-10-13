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
defined('APPWEBPATH') or define('APPWEBPATH', APPPATH . 'src' . DS . 'Web' . DS);
defined('CONTROLLERPATH') or define('CONTROLLERPATH', APPPATH . 'src' . DS . 'Web' . DS . 'Controllers' . DS);
defined('VIEWPATH') or define('VIEWPATH', APPPATH . 'src' . DS . 'Web' . DS . 'Views' . DS);
defined('VENDORPATH') or define('VENDORPATH', ROOT . 'vendor' . DS);
defined('SYSCOREPATH') or define('SYSCOREPATH', VENDORPATH . 'fonto' . DS . 'src' . DS . 'Fonto' . DS . 'Core' . DS);
defined('WEBPATH') or define('WEBPATH', ROOT . 'web' . DS);

$paths = array(
	'app'    => APPPATH,
	'core'   => SYSCOREPATH,
	'web'    => WEBPATH,
	'appweb' => APPWEBPATH,
	'vendor' => VENDORPATH
);

/**
 * Launch bootstrap
 */
include $paths['app'] . 'bootstrap' . EXT;