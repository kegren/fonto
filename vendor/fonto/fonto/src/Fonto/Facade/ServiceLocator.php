<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Facade
 * @link     https://github.com/kegren/fonto
 * @version  0.6
 */

namespace Fonto\Facade;

use Fonto\Facade\Facade;

class ServiceLocator extends Facade
{
    public function getFacade()
    {
        return 'ServiceLocator';
    }
}