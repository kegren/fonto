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

class ClassNotFound extends \Exception
{
    public function __construct($message = null, $code = 404)
    {
        if (null === $message) {
            $message = "Class not found";
        }
         parent::__construct($message, $code);
    }
}