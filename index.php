<?php
/**
 * Part of Fonto Framework
 *
 * Define constants and set paths
 */


/**
 * Define custom constants
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('EXT') or define('EXT', '.php');

/**
 * Define paths
 */
defined('ROOT') or define('ROOT', realpath(__DIR__). DS);
defined('CONFIGPATH') or define('CONFIGPATH', ROOT . "config" . DS);
defined('APPPATH') or define('APPPATH', ROOT . 'app' . DS);
defined('VENDORPATH') or define('VENDORPATH', ROOT . 'vendor' . DS);
defined('SYSCOREPATH') or define('SYSCOREPATH', VENDORPATH . 'fonto' . DS . 'fonto' . DS . 'src' . DS . 'Fonto' . DS);
defined('SYSCOREAPPPATH') or define('SYSCOREAPPPATH', VENDORPATH . 'fonto' . DS . 'fonto' . DS . 'src' . DS . 'Fonto' . DS . 'Application' . DS);
defined('WEBPATH') or define('WEBPATH', ROOT . 'web' . DS);
defined('SESSPATH') or define('SESSPATH', APPPATH . 'storage' . DS . 'session');

/**
 * Launch bootstrap
 */
include APPPATH . 'bootstrap' . EXT;
