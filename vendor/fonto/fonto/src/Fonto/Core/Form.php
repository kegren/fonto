<?php

namespace Fonto\Core;

class Form
{
	public function open($url, $method, $attributes = array(), $enctype = false)
	{
		$attr = '';
		$enct = '';

		if ($attributes) {
			foreach ($attributes as $id => $value) {
				$attr .= $id . '="'.$value.'"' . ' ';
			}
		}

		if ($enctype) {
			$enct = 'enctype="multipart/form-data"';
		}

		return '<form action="'.$url.'" method="'.$method.'" '.$enct.' '.$attr.'>';
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