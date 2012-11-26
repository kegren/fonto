<?php

namespace Fonto\Core\Application;

use Fonto\Core\Di;
use Fonto\Core\Routing\Router;
use Fonto\Core\Http\Request;
use Fonto\Core\Http\Response;
use Fonto\Core\Config;
use Fonto\Core\FontoException;
use Fonto\Core\Controller;
use Fonto\Core\Url;
use Fonto\Core\View\View;
use Fonto\Core\Session;
use Fonto\Core\Form\Form;
use Fonto\Core\Validation\Validator;
use ActiveRecord;
use Hautelook\Phpass\PasswordHash;
use Fonto\Core\Authentication\Auth;
use Fonto\Core\View\Helper\Css;

use HTMLPurifier as Purifier;

abstract class Base
{
    protected $version = '0.5 alpha';

    protected $timezone = 'Europe/Stockholm';

    protected $di;

    protected $env;

    protected $lang;

    protected $defaultApp;

    protected $activeApp;

    protected $dbLocal = array();

    protected $dbServer = array();

    public static $count = 0;

    public function __construct(array $appOptions = array())
    {
        if (!is_array($appOptions)) {
            throw new FontoException('$appOptions most be an array' . gettype($appOptions) . ' given');
        }

        $this->defaultApp = $appOptions['defaultApp'];
        $this->activeApp = $appOptions['activeApp'];

        $this->setPaths();

        $appConfig = appConfig();
        $this->env = $appConfig['environment'];
        $this->lang = $appConfig['language'];
        $this->timezone = $appConfig['timezone'];
        $this->dbLocal = $appConfig['database']['local'];
        $this->dbServer = $appConfig['database']['server'];

        $this->setLangPath();

        // Register autoloader for HTMLPurifier
        \HTMLPurifier_Bootstrap::registerAutoload();

        $this->di = new DI\Container();

        $this->di->setService(
            'config',
            $this->di->shared(
                function () {
                    return new Config\Base(new \Fonto\Core\Config\PhpNative);
                }
            )
        );

        $this->di->setService(
            'request',
            function () {
                return new \Fonto\Core\Http\Request();
            }
        );

        $this->di->setService(
            'router',
            function () {
                return new Router($this->di->getService('config'), $this->di->getService('request'), $this->activeApp);
            }
        );

        $this->di->setService(
            'controller',
            function () {
                return new Fonto\Core\Controller\Base();
            }
        );

        $this->di->setService(
            'response',
            function () {
                return new \Fonto\Core\Http\Response();
            }
        );

        $this->di->setService(
            'url',
            function () {
                return new \Fonto\Core\Url();
            }
        );

        $this->di->setService(
            'form',
            function () {
                return new Fonto\Core\Form\Form();
            }
        );

        $this->di->setService(
            'validator',
            function () {
                return new Fonto\Core\Validation\Validator();
            }
        );

        $this->di->setService(
            'view',
            function () {
                $driver = new \Fonto\Core\View\Driver(array('driver' => 'native'));
                $driverObj = $driver->init();
                return $driverObj;
            }
        );

        $this->di->setService(
            'session',
            function () {
                $sessionName = $this->di->getService('config')->load('app', 'sessionName');
                return new \Fonto\Core\Session\Base($sessionName);
            }
        );

        $this->di->setService(
            'twig',
            function () {
                $loader = new \Twig_Loader_Filesystem(VIEWPATH);
                $twig = new \Twig_Environment($loader);

                return $twig;
            }
        );

        $this->di->setService(
            'phpass',
            function () {
                return new Hautelook\Phpass\PasswordHash\PasswordHash(8, false);
            }
        );

        $this->di->setService(
            'purifier',
            function () {
                $cfg = \HTMLPurifier_Config::createDefault();
                $purifier = new \HTMLPurifier($cfg);

                return $purifier;
            }
        );

        $this->di->setService(
            'auth',
            function () {
                return new Fonto\Core\Authentication\Auth();
            }
        );

        $this->di->setService(
            'css',
            function () {
                return new \Fonto\Core\View\Helper\Css($this->di->getService('url'), $this->activeApp);
            }
        );
    }

    public function setActiveApp($activeApp)
    {
        $this->activeApp = $activeApp;
    }

    public function getActiveApp()
    {
        return $this->activeApp;
    }

    public function setDbLocal($dbLocal)
    {
        $this->dbLocal = $dbLocal;
    }

    public function getDbLocal()
    {
        return $this->dbLocal;
    }

    public function setDbServer($dbServer)
    {
        $this->dbServer = $dbServer;
    }

    public function getDbServer()
    {
        return $this->dbServer;
    }

    public function setDefaultApp($defaultApp)
    {
        $this->defaultApp = $defaultApp;
    }

    public function getDefaultApp()
    {
        return $this->defaultApp;
    }

    public function getConfig()
    {
        return $this->di->getService('config');
    }

    public function setDi($di)
    {
        $this->di = $di;
    }

    public function getDi()
    {
        return $this->di;
    }

    public function setEnv($env)
    {
        $this->env = $env;
    }

    public function getEnv()
    {
        return $this->env;
    }

    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    public function getTimezone()
    {
        return $this->timezone;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getVersion()
    {
        return $this->version;
    }

    private function setLangPath()
    {
        if (!defined('LANGPATH')) {
            define('LANGPATH', APPWEBPATH . 'Language' . DS . $this->lang . DS);
        }
    }

    /**
     * Defines paths based on the application name
     */
    private function setPaths()
    {
        if (!defined('CONFIGPATH')) {
            define('CONFIGPATH', APPPATH . 'src' . DS . $this->activeApp . DS . 'Config' . DS);
        }


        if (!defined('APPWEBPATH')) {
            define('APPWEBPATH', APPPATH . 'src' . DS . $this->activeApp . DS);
        }

        if (!defined('CTLPATH')) {
            define('CTLPATH', APPPATH . 'src' . DS . $this->activeApp . DS . 'Controller' . DS);
        }


        if (!defined('VIEWPATH')) {
            define('VIEWPATH', APPPATH . 'src' . DS . $this->activeApp . DS . 'View' . DS);
        }

        if (!defined('SESSPATH')) {
            define('SESSPATH', APPWEBPATH . 'Storage' . DS . 'Session' . DS);
        }


        if (!defined('MODELPATH')) {
            define('MODELPATH', APPPATH . 'src' . DS . $this->activeApp . DS . 'Model' . DS);
        }

    }
}