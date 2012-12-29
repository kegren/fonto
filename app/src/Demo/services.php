<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Fonto\Core\Config\ConfigManager;
use Fonto\Core\Config\Driver\PhpDriver;
use Doctrine\Common\Cache\ApcCache;

/**
 * Configuration object
 */
$config = new ConfigManager(new PhpDriver());

$di->setService(
    'EntityManager',
    function () use ($config) {

        if (CACHE) {
            // set up caching with APC for production mode
            $cache = new ApcCache;
        } else {
            $cache = new ArrayCache();
        }


        $env = $config->read('app#environment');
        $database = $config->read('app#database');
        $databaseConfiguration = $database[$env];

        $configuration = new Configuration();
        $configuration->setMetadataCacheImpl($cache);
        $configuration->setQueryCacheImpl($cache);

        $driverImpl = $configuration->newDefaultAnnotationDriver('model');
        $configuration->setMetadataDriverImpl($driverImpl);
        $configuration->setProxyDir(STORAGEPATH . 'Proxies');
        $configuration->setProxyNamespace('proxies');

        $configuration->setAutoGenerateProxyClasses(true);
        $configuration->getAutoGenerateProxyClasses();

        $em = EntityManager::create($databaseConfiguration, $configuration);

        return $em;
    }
);

$di->setService(
    'Purifier',
    function () {
        $cfg = \HTMLPurifier_Config::createDefault();
        $purifier = new \HTMLPurifier($cfg);

        return $purifier;
    }
);