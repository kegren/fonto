<?php
/**
 * Part of Fonto framework
 */

function _vd($dumpy)
{
	echo "<pre>";
	var_dump($dumpy);
	echo "</pre>";
	die;
}

function _pr($dumpy)
{
	echo "<pre>";
	print_r($dumpy);
	echo "</pre>";
	die;
}

function _ed($dumpy)
{
	echo $dumpy;
	die;
}