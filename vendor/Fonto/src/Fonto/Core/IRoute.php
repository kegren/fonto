<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 */

namespace Fonto\Core;

interface IRoute
{
	public function getRoutes();

	public function create($uri);
}