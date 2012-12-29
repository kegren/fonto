<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Helper
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\Helper;

/**
 * Base class for form models.
 *
 * @package Fonto_Helper
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Arr
{
    /**
     * Removes empty and null values in an array
     *
     * @param  array $array
     * @return array
     */
    public function cleanArray(array $array = array())
    {
        return array_filter(
            $array,
            function ($element) {
                return !empty($element);
            }
        );
    }

    /**
     * Trims all values in an array
     *
     * @param  array $array
     * @return array
     */
    public function trimArray(array $array = array())
    {
        return array_map(
            function ($element) {
                return trim($element);
            },
            $array
        );
    }
}