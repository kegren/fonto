<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Error
 * @link     https://github.com/kegren/fonto
 * @version  0.6
 */

namespace Fonto\Error;

use Exception;

/**
 * Error handler class.
 *
 * @package Fonto_Error
 * @link    https://github.com/kegren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Handler extends Exception
{
    /**
     * Returns error output
     *
     * @param Exception $e
     */
    public function handleException(Exception $e)
    {
        echo get_class($e) . "<br />" . $e->getMessage() . "<br />" . $e->getLine() . "<br />" . $e->getFile();
    }
}