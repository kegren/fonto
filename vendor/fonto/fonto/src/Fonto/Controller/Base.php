<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Controller
 * @link     https://github.com/kegren/fonto
 * @version  0.2
 */

namespace Fonto\Controller;

/**
 * Base controller class.
 *
 * @package Fonto_Controller
 * @link    https://github.com/kegren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Base
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
     * Default rest method
     *
     * @var string
     */
    protected $restfulAction = 'index';
}
