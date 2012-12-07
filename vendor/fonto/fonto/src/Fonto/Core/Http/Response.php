<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Http;

use Fonto\Core\Url;

class Response
{
    /**
     * @var \Fonto\Core\Url
     */
    private $url;

    /**
     * @var array
     */
    protected $codes = array(
        200 => 'OK',
        403 => 'Forbidden',
        404 => 'Not found'
    );

    /**
     * @var array
     */
    private $views = array(
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

    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    /**
     * Redirects request
     *
     * @param $url
     */
    public function redirect($url, $code = 200)
    {
        $to = $this->url->baseUrl() . $url;
        header("Location: $to");
        exit;
    }

    public function error($code)
    {
        $view = new \Fonto\Core\View\Driver('native');
        $view->init();
        return $view->render($this->views[$code], array('e' => 'Sidan kunde inte hittas!'));
    }
}