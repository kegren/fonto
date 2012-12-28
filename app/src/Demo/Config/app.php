<?php
/**
 * Part of Fonto Framework
 *
 * Application settings
 */

return array(
    /**
     * language
     */
    'language' => 'en',
    /**
     * Default timezone
     */
    'timezone' => 'Europe/Stockholm',
    /**
     * Database settings
     */
    'database' => array(
        'local' => array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'doctrine',
            'user' => 'root',
            'password' => '',
        ),
        'server' => array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'doctrine',
            'user' => 'root',
            'password' => '',
        ),
    ),
    /**
     * Application environment
     */
    'environment' => 'local',
);