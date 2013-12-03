<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Vendor
 * @link     https://github.com/kegren/fonto
 * @version  0.2
 */

namespace Fonto\Vendor;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\Common\Cache\ApcCache;
use Fonto\Facade\Config;

class Doctrine
{

    public function connect()
    {
        $cfg = Config::grab('app', true);

        if ($cfg['cache'] == 'apc') {
            $cache = new ApcCache();
        } else {
            $cache = new ArrayCache();
        }

        $env = $cfg['env'];
        $db = $cfg['db'];

        $settings = $db[$env];

        $configuration = new Configuration();
        $configuration->setMetadataCacheImpl($cache);
        $configuration->setQueryCacheImpl($cache);

        $driverImpl = $configuration->newDefaultAnnotationDriver('model');
        $configuration->setMetadataDriverImpl($driverImpl);
        $configuration->setProxyDir(STORAGEPATH . 'proxies');
        $configuration->setProxyNamespace('proxies');

        $configuration->setAutoGenerateProxyClasses(true);
        $configuration->getAutoGenerateProxyClasses();

        return EntityManager::create($settings, $configuration);
    }

}