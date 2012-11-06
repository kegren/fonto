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

	public function input($type, $name, $attributes = array())
	{
		$attr = '';

		if ($attributes) {
			foreach ($attributes as $id => $value) {
				$attr .= $id . '="'.$value.'"' . ' ';
			}
		}

		return '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" '.$attr.'>';
	}

	public function submit($value, $attributes = array())
	{
		$attr = '';

		if ($attributes) {
			foreach ($attributes as $id => $val) {
				$attr .= $id . '="'.$val.'"' . ' ';
			}
		}

		return '<input type="submit" value="'.$value.'" '.$attr.'>';
	}

	public function label($for, $text)
	{
		return '<label for="'.$for.'">'.$text.'</label>';
	}

	public function close()
	{
		return '</form>';
	}
}