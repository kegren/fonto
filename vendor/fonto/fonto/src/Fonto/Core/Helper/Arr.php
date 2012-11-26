<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\Helper;

class Arr
{
    /**
     * Removes empty and null values in an array
     *
     * @param array $array
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
     * @param array $array
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