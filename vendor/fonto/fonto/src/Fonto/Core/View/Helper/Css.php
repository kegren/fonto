<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\View\Helper;

use Fonto\Core\Url;

class Css
{
    private $url;

    private $activeApp;

    public function __construct(Url $url, $activeApp = null)
    {
        $this->url = $url;
        $this->activeApp = ($activeApp) ?: 'Demo';
    }

    public function cssLink($file)
    {
        return '<link rel="stylesheet" href="'.$this->getCssFile($file).'">'."\n";
    }

	public function getCssFile($file)
	{
		return "{$this->url->baseUrl()}web/app/{$this->activeApp}/css/{$file}.css";
	}
}