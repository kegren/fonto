<?php

namespace Fonto\Core\View\Driver;

interface DriverInterface
{
    /**
     * Renders a view with data
     *
     * @param $view
     * @param array $data
     * @return mixed
     */
    public function render($view, $data = array());

    /**
     * Searches for a view, returns boolean
     *
     * @param $view
     * @param $path
     * @param $extension
     * @return mixed
     */
    public function findView($view, $path, $extension);
}