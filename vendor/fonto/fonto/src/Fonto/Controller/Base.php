<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Controller;

use Fonto\Core\Application\ObjectHandler;


class Base extends ObjectHandler
{
    /**
     * @var string
     */
    protected $actionPrefix = 'Action';

    /**
     * @var string
     */
    protected $defaultAction = 'index';

    /**
     * @var array
     */
    protected $supported = array(
        'GET' => 'get',
        'POST' => 'post',
        'DELETE' => 'delete'
    );

    /**
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