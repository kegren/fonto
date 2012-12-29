<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Http;

use Fonto\Http\Url;
use Fonto\View\View;
use Fonto\Http\Session;
use Exception;

class Response
{
    /**
     * @var Url
     */
    protected $url;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var Session
     */
    protected $session;

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

    /**
     * Constructor
     *
     * @param Url $url
     * @param View $view
     * @param Session $session
     */
    public function __construct(Url $url, View $view, Session $session)
    {
        $this->url = $url;
        $this->view = $view;
        $this->session = $session;
    }

    /**
     * Redirects a user to given uri with data if given
     *
     * @param $url
     * @param array $data
     */
    public function redirect($url, $data = array())
    {
        if (array_key_exists('posted', $data)) {

            $postedData = $data['posted'];

            foreach ($postedData as $input) {
                $postedData[$input] = $input;
            }

            unset($data['posted']);
            $data = $data + $postedData;
        }

        $this->session->save('redirectData', $data); // Temporary

        session_write_close(); // Most call before header..

        $url = $this->url->baseUrl() . $url;
        header("Location: $url");
        die();
    }

    /**
     * Saves data to the session
     *
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function data($data = array())
    {
        if (!is_array($data)) {
            throw new Exception("You can only pass an array to the data method.");
        }

        foreach ($data as $id => $value) {
            $this->session->save($id, $value);
        }

        return true;
    }

    /**
     * Returns an error view based on provided code. Currently supported
     * views: 403, 404
     *
     * @param $code
     * @throws \Exception
     */
    public function error($code)
    {
        $view = isset($this->views[$code]) ? $this->views[$code] : false;

        if (false === $view) {
            throw new Exception("Error code not supported");
        }

        $e = $this->codes[$code];

        return $this->view->render(
            $view,
            array(
                'e' => $e,
                'baseUrl' => $this->url->baseUrl(),
                'code' => $code
            )
        );
    }
}