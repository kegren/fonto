<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\View\Helper;

use Fonto\Http\Url;

class Css
{
    /**
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
     * @param $file
     * @return string
     */
    public function cssLink($file)
    {
        return '<link rel="stylesheet" href="'.$this->getCssFile($file).'">'."\n";
    }

    /**
     * @param $file
     * @return string
     */
    public function getCssFile($file)
	{
		return "{$this->url->baseUrl()}web/app/" . ACTIVE_APP . "/css/{$file}.css";
	}
}