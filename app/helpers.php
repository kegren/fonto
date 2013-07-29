<?php
/**
 * Part of Fonto framework
 */

/**
 * var_dump
 *
 * @access  public
 */
function vd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die;
}


/**
 * print_r
 *
 * @access  public
 * @param   array
 */
function pr($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die;
}

/**
 * htmlentities
 *
 * @access public
 * @param  string
 */
function e($str)
{
    return htmlentities($str, ENT_QUOTES, "UTF-8");
}
