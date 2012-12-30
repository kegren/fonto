<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_DependencyInjection
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\DependencyInjection;

use Fonto\DependencyInjection;
use Closure;
use Exception;

/**
 * Acts as a manager and is responsible for
 * getting a service from the container and give it to
 * the builder class. Then it will be returned as an object
 * with all the correct dependencies set.
 *
 * @package Fonto_DependencyInjection
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Manager implements ManagerInterface
{
    /**
     * Container object
     *
     * @var Container
     */
    protected $container;

    /**
     * Builder object
     *
     * @var Builder
     */
    protected $builder;

    public function __construct(Container $container, Builder $builder)
    {
        $this->container = $container;
        $this->builder = $builder;
    }

    /**
     * Adds a service only if there isn't one already registered with that
     * id
     *
     * @param  string $id
     * @param  string $value
     * @return mixed|void
     */
    public function add($id, $value)
    {
        $this->getContainer()->addService($id, $value);
    }

    /**
     * Sets a service
     *
     * @param string $id
     * @param string $value
     * @return mixed|void
     */
    public function set($id, $value)
    {
        $this->getContainer()->setService($id, $value);
    }

    /**
     * Gets a service
     *
     * @param  string    $id
     * @param  bool      $throwException
     * @throws Exception
     * @return object
     */
    public function get($id, $throwException = true)
    {
        $service = $this->getContainer()->getService($id);

        if (false === $service) {

            if (false === $throwException) {
                return false;
            }

            throw new Exception("No service with the id: ($id) was found.");
        }

        if ($service instanceof Closure) {
            return $service();
        }

        return $this->getBuilder()->build($service);
    }

    /**
     * Returns registered services
     *
     * @return mixed
     */
    public function getCoreServices()
    {
        return $this->container->getCoreServices();
    }


    /**
     * Returns container object
     *
     * @return Container
     */
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * Returns builder object
     *
     * @return Builder
     */
    protected function getBuilder()
    {
        return $this->builder;
    }
}