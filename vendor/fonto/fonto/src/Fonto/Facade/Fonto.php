<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Facade
 * @link     https://github.com/kenren/fonto
 * @version  0.6
 */

namespace Fonto\Facade;

use Fonto\Facade\Facade;

class Fonto extends Facade
{
    public static function getFacade()
    {
        return 'Fonto';
    }
}