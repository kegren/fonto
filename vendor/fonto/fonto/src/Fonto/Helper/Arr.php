<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Helper
 * @link     https://github.com/kegren/fonto
 * @version  0.6
 */

namespace Fonto\Helper;

use Fonto\Facade\Facade;

/**
 * Base class for form models.
 *
 * @package Fonto_Helper
 * @link    https://github.com/kegren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Arr extends Facade
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

    public function test()
    {
        echo 5;
    }

    public static function getFacade()
    {
        #$class = explode('\\', __CLASS__);
        #return end($class);
        return 'Arr';
    }
}
