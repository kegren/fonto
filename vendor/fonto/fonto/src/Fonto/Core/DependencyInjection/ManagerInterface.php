<?php

namespace Fonto\Core\DependencyInjection;

interface ManagerInterface
{
    public function set($id, $value);

    public function add($id, $value);

    public function get($id);
}