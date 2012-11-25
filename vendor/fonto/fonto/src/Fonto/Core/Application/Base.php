<?php

namespace Fonto\Core\Application;

use Fonto\Core\FontoException;

abstract class Base
{
    protected $version = '0.5 alpha';

    protected $env;

    protected $timezone = 'Europe/Stockholm';

    protected $lang;

    protected $defaultApp;

    protected $activeApp;

    public function __construct(array $appOptions = array(), array $appConfig = array())
    {
        if (!is_array($appOptions) or !is_array($appConfig)) {
            throw new FontoException('Both $appOptions and $appConfig most be an array');
        }

        $this->defaultApp = $appOptions['defaultApp'];
        $this->activeApp = $appOptions['activeApp'];

        $this->env = $appConfig['env'];
        $this->lang = $appConfig['lang'];
        $this->timezone = $appConfig['timezone'];
    }


}