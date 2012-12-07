<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

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

use Hautelook\Phpass\PasswordHash;
use Fonto\Core\Authentication\Auth;
use Fonto\Core\View\Helper\Css;

use HTMLPurifier as Purifier;
use ArrayAccess;
use Countable;
use ActiveRecord;

abstract class Base
{
    /**
     * @var array
     */
    protected $base = array(
        'version' => '0.5 alpha',
        'timezone' => 'Europe/Stockholm',
        'defaultApp' => 'Demo',
        'activeApp' => 'Demo',
        'env' => 'local',
        'lang' => 'sv',
        'config' => 'php',
        'session' => array(
            'name' => 'Fonto Framework'
        ),
    );

    protected $data = array();

    public function __construct(array $appOptions = array())
    {
        if (!is_array($appOptions)) {
            throw new FontoException('$appOptions most be an array' . gettype($appOptions) . ' given');
        }

        $this['defaultApp'] = $appOptions['defaultApp'];
        $this['activeApp'] = $appOptions['activeApp'];

        $this->setPaths();

        $this['base'] = $this->base;

        $appConfig = appConfig();

        $this['env'] = $appConfig['environment'];
        $this['lang'] = $appConfig['language'];
        $this['timezone'] = $appConfig['timezone'];
        $this['dbLocal'] = $appConfig['database']['local'];
        $this['dbServer'] = $appConfig['database']['server'];

        echo $this->count();

        $this->setLangPath();

        // Register autoloader for HTMLPurifier
        \HTMLPurifier_Bootstrap::registerAutoload();

        $this['di'] = new DI\Container();


        $di = new DI\DIManager(new DI\Configrator());
        $di->setService('test', '\Example\Test\Lek');
        $di->getService('config');

        die;




        //$this['di']->setService('config', function () {
        //        return new \Fonto\Core\Config\ConfigManager(new \Fonto\Core\Config\Driver\PhpDriver());
        //});

        $config = new \Fonto\Core\Config\ConfigManager(array(
            'driver' => 'php'
        ));

        echo $config->load(array(
               'file' => 'app',
                'option' => 'sessionName'
            ));

        throw new \FelException("gaah");


        die;

        $config = $this['di']->getService('config');
        echo $config->load(array(
               'file' => 'app',
                'option' => 'config'
            ));


       echo 2;

       $memcache = new \Fonto\Core\Cache\CacheManager(array(
           'driver' => 'memcache'
       ));

        $memcache->set('test', 'testar');
        $memcache->flush();

        echo $memcache->get('test');

        _vd($memcache);

        _vd($config);

        die;

        $this['di']->setService(
            'config',
            $this['di']->shared(
                function () {
                    return new Config\Base(new \Fonto\Core\Config\PhpNative);
                }
            )
        );

        $this['di']->setService(
            'request',
            function () {
                return new \Fonto\Core\Http\Request();
            }
        );

        $this['di']->setService(
            'router',
            function () {
                return new Router($this['di']->getService('config'), $this['di']->getService(
                    'request'
                ), $this['activeApp']);
            }
        );

        $this['di']->setService(
            'controller',
            function () {
                return new Fonto\Core\Controller\Base();
            }
        );

        $this['di']->setService(
            'response',
            function () {
                return new \Fonto\Core\Http\Response($this->di->getService('url'));
            }
        );

        $this['di']->setService(
            'url',
            function () {
                return new \Fonto\Core\Url();
            }
        );

        $this['di']->setService(
            'form',
            function () {
                return new Fonto\Core\Form\Form();
            }
        );

        $this['di']->setService(
            'validator',
            function () {
                return new \Fonto\Core\Validation\Validator();
            }
        );

        $this['di']->setService(
            'view',
            function () {
                $driver = new \Fonto\Core\View\Driver(array('driver' => 'native'));
                $driverObj = $driver->init();
                return $driverObj;
            }
        );

        $this['di']->setService(
            'session',
            function () {
                $sessionName = $this['di']->getService('config')->load('app', 'sessionName');
                return new \Fonto\Core\Session\Base($sessionName);
            }
        );

        $this['di']->setService(
            'twig',
            function () {
                $loader = new \Twig_Loader_Filesystem(VIEWPATH);
                $twig = new \Twig_Environment($loader);

                return $twig;
            }
        );

        $this['di']->setService(
            'phpass',
            function () {
                return new Hautelook\Phpass\PasswordHash\PasswordHash(8, false);
            }
        );

        $this['di']->setService(
            'purifier',
            function () {
                $cfg = \HTMLPurifier_Config::createDefault();
                $purifier = new \HTMLPurifier($cfg);

                return $purifier;
            }
        );

        $this['di']->setService(
            'auth',
            function () {
                return new Fonto\Core\Authentication\Auth();
            }
        );

        $this['di']->setService(
            'css',
            function () {
                return new \Fonto\Core\View\Helper\Css($this['di']->getService('url'), $this->activeApp);
            }
        );
    }


}