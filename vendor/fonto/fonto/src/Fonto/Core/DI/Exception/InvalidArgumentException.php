<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\DI\Exception;

class InvalidArgumentException extends \Exception
{
    public function __construct($message = null, $code = 0)
    {
        if (null === $message) {
            $message = "Invalid argument";
        }
        parent::__construct($message, $code);
    }
}