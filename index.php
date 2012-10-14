<?php

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
defined('CONFIGPATH') or define('CONFIGPATH', APPPATH . 'src' . DS . 'Web' . DS . 'Config' . DS);
defined('CONTROLLERPATH') or define('CONTROLLERPATH', APPPATH . 'src' . DS . 'Web' . DS . 'Controllers' . DS);
defined('VIEWPATH') or define('VIEWPATH', APPPATH . 'src' . DS . 'Web' . DS . 'Views' . DS);
defined('VENDORPATH') or define('VENDORPATH', ROOT . 'vendor' . DS);
defined('FONTOCOREPATH') or define('FONTOCOREPATH', VENDORPATH . 'fonto' . DS . 'fonto' . DS . 'src' . DS . 'Fonto' . DS . 'Core' . DS);
defined('WEBPATH') or define('WEBPATH', ROOT . 'web' . DS);

$paths = array(
	'app'    => APPPATH,
	'core'   => FONTOCOREPATH,
	'web'    => WEBPATH,
	'appweb' => APPWEBPATH,
	'vendor' => VENDORPATH,
	'config' => CONFIGPATH
);

/**
 * Launch bootstrap
 */
include $paths['app'] . 'bootstrap' . EXT;