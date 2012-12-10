<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Http;

use Fonto\Core\Http\Url;
use Fonto\Core\View\View;

class Response
{
    /**
     * @var \Fonto\Core\Http\Url
     */
    protected $url;

    /**
     * @var \Fonto\Core\View\View
     */
    protected $view;

    /**
     * @var array
     */
    protected $codes = array(
        200 => 'OK',
        202 => 'Accepted',
        301 => 'Moved Permanently',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
    );

    /**
     * @var array
     */
    protected $views = array(
        403 => 'error/403',
        404 => 'error/404'
    );

    /**
     * @var
     */
    protected $status;

    /**
     * @var
     */
    protected $contentType;

    /**
     * @var
     */
    protected $header;


    public function __construct(Url $url, View $view)
    {
        $this->url = $url;
        $this->view = $view;
    }

    /**
     * @param $url
     * @param int $code
     */
    public function redirect($url, $code = 200)
    {
        $to = $this->url->baseUrl() . $url;
        header("Location: $to");
        exit;
    }

    /**
     * @param $code
     * @return mixed
     */
    public function error($code)
    {
        return $this->view->render($this->views[$code], array('e' => 'Sidan kunde inte hittas!'));
    }
}