<?php

namespace Fonto\Core\DependencyInjection;

use Fonto\Core\DependencyInjection;

class Manager implements ManagerInterface
{
    protected $container;

    protected $builder;

    public function __construct(Container $container, Builder $builder)
    {
        $this->container = $container;
        $this->builder = $builder;
    }
}