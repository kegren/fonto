<?php

namespace Fonto\Core;

class Form
{
	public function open($url, $method)
	{
		return '<form action='.$url.' method='.$method.'>';
	}

	public function label($for, $text)
	{
		return '<label for='.$for.'>'.$text.'</label>';
	}

	public function close()
	{
		return '</form>';
	}
}