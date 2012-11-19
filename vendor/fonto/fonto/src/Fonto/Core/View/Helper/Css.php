<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 * @package Fonto
 * @link https://github.com/kenren/fonto
 */

namespace Fonto\Core\View\Helper;

use Fonto\Core\Application\App;

class Css
{
	protected $app;

	public function setApp(App $app)
	{
		$this->app = $app;
	}

	public function getCssFile($file)
	{
		$baseUrl = $this->app->getUrl()->baseUrl();
		$activeApp = $this->app->getActiveApp();

		return "{$baseUrl}web/app/{$activeApp}/css/{$file}.css";
	}
}