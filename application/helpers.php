<?php
/**
 * Part of Fonto framework
 */

if ( ! function_exists('_vd')) {
	function _vd($data) {
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
		die;
	}
}

if (!function_exists('_pr')) {
	function _pr($data) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die;
	}
}

if (!function_exists('_ed')) {
	function _ed($data) {
		echo $data;
		die;
	}
}
