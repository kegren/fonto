<?php
/**
 * Part of Fonto Framework
 */
return array(
    /**
     * language
     */
    'lang' => 'en',
    /**
     * Default timezone
     */
    'timezone' => 'Europe/Stockholm',
    /**
     * Database settings
     */
    'db' => array(
        'development' => array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'fonto_development',
            'user' => 'root',
            'password' => 'qwerty'
        ),
        'production' => array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'fonto_production',
            'user' => 'root',
            'password' => ''
        ),
    ),
    /**
     * Application environment
     */
    'env' => 'development',
    /**
     * Cache
     *
     * Supported: apc, memcache
     */
    'cache' => ''
);
