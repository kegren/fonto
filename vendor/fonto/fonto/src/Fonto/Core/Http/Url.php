<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Http;

class Url
{
    /**
     * Create base url for application.
     *
     * @return string base url
     */
    public function baseUrl()
    {
        $url = '';
        if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
            $url = 'https';
        } else {
            $url = 'http';
        }
        $url .= '://' . $_SERVER['HTTP_HOST'];
        $url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        return (string)$url;
    }

    /**
     * @param $url
     * @return string
     */
    public function urlSlug($url)
    {
        $slug = str_replace(
            array('å', 'ä', 'ö', 'Å', 'Ä', 'Ö'),
            array('a', 'a', 'o', 'Å', 'Ä', 'Ö'),
            $url
        );
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $slug);
        return strtolower($slug);
    }
}