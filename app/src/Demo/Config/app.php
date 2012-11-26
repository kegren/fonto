<?php
/**
 * Part of Fonto Framework
 *
 * Application settings
 */

return array(
    /**
     * Sets language
     */
    'language' => 'sv',
    /**
     * Sets Default timezone
     */
    'timezone' => 'Europe/Stockholm',
    /**
     * Sets database settings
     */
    'database' => array(
        'local' => array(
            'type' => 'mysql',
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '',
            'name' => 'fontomvc'
        ),
        'server' => array(
            'type' => 'mysql',
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '',
            'name' => 'fonto'
        ),
    ),
    /**
     * Sets application environment, development enables error_reporting(-1)
     */
    'environment' => 'local',
    /**
     * Sets baseUrl for application
     */
    'baseUrl' => '',
    /**
     * Enables twig
     */
    'twig' => false,
    /**
     *
     */
    'sessionName' => 'FontoMVC',
    /**
     *
     */
    'config' => '.php'
);