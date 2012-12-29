<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Controller
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\Controller;

use Fonto\Application\ObjectHandler;

/**
 * Base controller class.
 *
 * @package Fonto_Controller
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Base extends ObjectHandler
{
    /**
     * Prefix for methods
     *
     * @var string
     */
    protected $actionPrefix = 'Action';

    /**
     * Default method
     *
     * @var string
     */
    protected $defaultAction = 'index';

    /**
     * Current supported rest
     *
     * @var array
     */
    protected $supported = array(
        'GET' => 'get',
        'POST' => 'post',
        'DELETE' => 'delete'
    );

    /**
     * Default rest method
     *
     * @var string
     */
    protected $restfulAction = 'Index';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
}