<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Documentation
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\Documentation;

use Fonto\Application\ObjectHandler;

/**
 * Gets all core packages inside the vendor/fonto dir.
 *
 * @package Fonto_Documentation
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Package extends ObjectHandler
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Returns all core services
     *
     * @return array
     */
    public function getCoreServices()
    {
        $services = $this->getDi()->getCoreServices();
        $this->services = $services;
        $fixed = array();

        foreach ($services as $args) {

            foreach ($args as $option => $value) {

                if ($option == 'class') {
                    $class = substr($value, 1);
                }

                if (is_array($value)) {

                    foreach ($value as $namespaced) {
                        $fixed[$class][] = substr($namespaced, 1);
                    }


                }

                $fixed[$class]['id'] = isset($args['id']) ? $args['id'] : '';
            }

        }

        return $fixed;
    }

    /**
     * Returns all core objects
     *
     * @return array
     */
    public function getCoreObjects()
    {
        $objects = array();

        foreach ($this->objects as $id => $class) {
            $objects[$id] = substr($class, 1);
        }

        return $objects;
    }
}