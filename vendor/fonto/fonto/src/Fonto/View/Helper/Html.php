<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_View
 * @subpackage  Helper
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\View\Helper;


/**
 * A small helper class for html elements
 *
 * @package    Fonto_View
 * @subpackage Helper
 * @link       https://github.com/kenren/fonto
 * @author     Kenny Damgren <kenny.damgren@gmail.com>
 */
class Html
{
    /**
     * Returns a html link
     *
     * @param string  $baseUrl
     * @param array   $args
     * @param string  $text
     * @return string
     */
    public function createLink($baseUrl, $args = array(), $text)
    {
        $arguments = '';

        foreach($args as $arg) {
            $arguments .= $arg . "/";
        }

        $arguments = substr($arguments, 0, -1);
        $arguments = $baseUrl.$arguments;

        return '<a href="'.$arguments.'">'.$text.'</a>'."\n";
    }

    /**
     * Returns an image link
     *
     * @param  string $baseUrl
     * @param  string $link
     * @param  string $alt
     * @return string
     */
    public function createImgLink($baseUrl, $link, $alt)
    {
        return '<img src="'.$baseUrl.$link.'" alt="'.$alt.'">'."\n";
    }
}