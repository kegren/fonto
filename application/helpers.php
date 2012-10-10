<?php
/**
 * Part of Fonto framework
 */

/**
 * Shorthand function for var_dump
 *
 * @access  public
 */
if ( ! function_exists('_vd')) {
	function _vd($data) {
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
		die;
	}
}

/**
 * Shorthand function for print_r
 *
 * @access  public
 * @param   array
 */
if (!function_exists('_pr')) {
	function _pr($data) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die;
	}
}

/**
 * Shorthand function for echo
 *
 * @access  public
 * @param   string
 */
if (!function_exists('_ed')) {
	function _ed($data) {
		echo $data;
		die;
	}
}
