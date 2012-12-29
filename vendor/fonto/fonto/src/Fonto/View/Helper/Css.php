<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_View
 * @subpackage  Helper
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\View\Helper;

use Fonto\Http\Url;

/**
 * A small helper class for css inside the view
 *
 * @package    Fonto_View
 * @subpackage Helper
 * @link       https://github.com/kenren/fonto
 * @author     Kenny Damgren <kenny.damgren@gmail.com>
 */
class Css
{
    /**
     * Url object
     *
     * @var \Fonto\Http\Url
     */
    private $url;

    /**
     * Constructor
     *
     * @param \Fonto\Http\Url $url
     */
    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    /**
     * Returns a css link
     *
     * @param $file
     * @return string
     */
    public function cssLink($file)
    {
        return '<link rel="stylesheet" href="'.$this->getCssFile($file).'">'."\n";
    }

    /**
     * Returns full path to a css file
     *
     * @param  string $file
     * @return string
     */
    public function getCssFile($file)
	{
		return "{$this->url->baseUrl()}web/app/" . ACTIVE_APP . "/css/{$file}.css";
	}
}