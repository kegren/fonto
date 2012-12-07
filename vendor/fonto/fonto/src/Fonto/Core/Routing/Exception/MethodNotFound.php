<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Routing\Exception;

class MethodNotFound extends \BadMethodCallException
{
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }
}