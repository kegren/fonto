<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Application
 * @link     https://github.com/kegren/fonto
 * @version  0.6
 */

namespace Fonto\Application;

use Fonto\DependencyInjection\ServiceLocator;

class Fonto
{
    public function grab($class)
    {
        if ($obj = $this->getServiceLocator()->get($class)) {
            return $obj;
        }

        return false;
    }

    /**
     * Returns a service locator instance. Used for creating a new
     * instance.
     *
     * @return [type] [description]
     */
    public function getServiceLocator()
    {
        return new ServiceLocator();
    }
}
