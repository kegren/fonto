<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\DependencyInjection;

use Fonto\Core\DependencyInjection;
use Closure;
use Exception;

class Manager implements ManagerInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Builder
     */
    protected $builder;

    public function __construct(Container $container, Builder $builder)
    {
        $this->container = $container;
        $this->builder = $builder;
    }

    /**
     * @param $id
     * @param $value
     */
    public function add($id, $value)
    {
        $this->getContainer()->addService($id, $value);
    }

    /**
     * @param $id
     * @param $value
     */
    public function set($id, $value)
    {
        $this->getContainer()->setService($id, $value);
    }

    /**
     * @param $id
     * @param bool $throwException
     * @throws \Exception
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

    protected function getContainer()
    {
        return $this->container;
    }

    protected function getBuilder()
    {
        return $this->builder;
    }
}