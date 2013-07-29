<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_DependencyInjection
 * @link     https://github.com/kenren/fonto
 * @version  0.6
 */
return array(
    'app' => array(
        'class' => 'Fonto\Application\App',
        'alias' => 'app'
    ),

    'fonto' => array(
        'class' => 'Fonto\Application\Fonto',
        'alias' => 'fonto'
    ),

    'controller' => array(
        'class' => 'Fonto\Controller\Base',
        'alias' => 'controller'
    ),

    'error' => array(
        'class' => 'Fonto\Error\Handler',
        'alias' => 'error'
    ),

    'form' => array(
        'class' => 'Fonto\Form\Form',
        'alias' => 'form'
    ),

    'arr' => array(
        'class' => 'Fonto\Helper\Arr',
        'alias' => 'arr'
    ),

    'route' => array(
        'class' => 'Fonto\Routing\Route',
        'alias' => 'route'
    ),

    'validation' => array(
        'class' => 'Fonto\Validation\Validator',
        'alias' => 'validation'
    ),

    'config' => array(
        'class' => 'Fonto\Config\ConfigManager',
        'alias' => 'config',
    ),

    'router' => array(
        'class' => 'Fonto\Routing\Router',
        'alias' => 'router',
    ),

    'response' => array(
        'class' => 'Fonto\Http\Response',
        'alias' => 'response',
    ),

    'request' => array(
        'class' => 'Fonto\Http\Request',
        'alias' => 'request',
    ),

    'view' => array(
        'class' => 'Fonto\View\View',
        'alias' => 'view',
    )
);
