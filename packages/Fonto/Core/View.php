<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 */

namespace Fonto\Core;

use Fonto\Core\Error;

class View
{
	const DEFAULT_EXT = '.php';

	/**
	 * Render view file with data
	 *
	 * @param  string $view
	 * @param  array $data
	 * @return file
	 */
	public static function show($view, array $data = array())
	{
		extract($data);

		include VIEWPATH . $view . View::DEFAULT_EXT;
	}
}