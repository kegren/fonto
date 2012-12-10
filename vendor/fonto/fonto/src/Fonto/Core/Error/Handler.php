<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Error;

use Exception;

class Handler extends Exception
{
    /**
     * @param \Exception $e
     */
    public function handleException(Exception $e)
    {
        echo get_class($e) . "<br />" . $e->getMessage() . "<br />" . $e->getLine() . "<br />" . $e->getFile();
    }
}