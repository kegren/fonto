<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

$__defaultNs = '\Fonto\Core';

$app = $__defaultNs . '\Application\App';
$auth = $__defaultNs . '\Authentication\Auth';
$cache = $__defaultNs . '\Cache\CacheManager';
$config = $__defaultNs . '\Config\ConfigManager';
$controller = $__defaultNs . '\Controller\Base';
$form = $__defaultNs . '\Form\Form';
$formModel = $__defaultNs . '\FormModel\Base';
$arr = $__defaultNs . '\Helper\Arr';
$request = $__defaultNs . '\Http\Request';
$router = $__defaultNs . '\Routing\Router';
$route = $__defaultNs . '\Routing\Route';
$response = $__defaultNs . '\Http\Response';
$hash = $__defaultNs . '\Security\Hash';
$session = $__defaultNs . '\Session\Base';
$validator = $__defaultNs . '\Validation\Validator';
$view = $__defaultNs . '\View\View';
$url = $__defaultNs . '\Url';

$classes = array(
    'App' => $app,
    'Auth' => $auth,
    'Cache' => $cache,
    'Controller' => $controller,
    'Form' => $form,
    'FormModel' => $formModel,
    'Arr' => $arr,
    'Request' => $request,
    'Route' => $route,
    'Hash' => $hash,
    'Session' => $session,
    'Validator' => $validator,
    'View' => $view,
    'Url' => $url,
);


$services = array(
    'Config' => array(
        'class' => $config,
        'defaultArguments' => array(
            'driver' => 'php'
        ),
    ),
    'Router' => array(
        'class' => $router,
        'defaultArguments' => array(
             'instance' => array(
                 'Route',
                 'Request'
             )
        ),
    ),
    'Response' => array(
        'class' => $response,
        'defaultArguments' => array(
            'instance' => array(
                'Url',
                'Request'
            )
        ),
    )
);

return compact(array('classes', 'services'));