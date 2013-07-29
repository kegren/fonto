<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Application
 * @link     https://github.com/kenren/fonto
 * @version  0.5
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