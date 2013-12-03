<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Form
 * @link     https://github.com/kegren/fonto
 * @version  0.2
 */

namespace Fonto\Form;

/**
 * A small helper class for building form elements through
 * php.
 *
 * @package Fonto_Form
 * @link    https://github.com/kegren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Form
{
    /**
     * Returns an open form tag
     *
     * @param  string  $url
     * @param  string  $method
     * @param  array   $attributes
     * @param  boolean $enctype
     * @return mixed
     */
    public function open($url, $method, $attributes = array(), $enctype = false)
    {
        $attr = '';
        $enct = '';

        if ($attributes) {
            foreach ($attributes as $id => $value) {
                $attr .= $id . '="' . $value . '"' . ' ';
            }
        }

        if ($enctype) {
            $enct = 'enctype="multipart/form-data"';
        }

        return '<form action="' . $url . '" method="' . $method . '" ' . $enct . ' ' . $attr . '>' . "\n";
    }

    /**
     * Returns an input field
     *
     * @param  string $type
     * @param  string $name
     * @param  array  $attributes
     * @return mixed
     */
    public function input($type, $name, $attributes = array())
    {
        $attr = '';

        if ($attributes) {
            foreach ($attributes as $id => $value) {
                $attr .= $id . '="' . $value . '"' . ' ';
            }
        }

        return '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" ' . $attr . '>' . "\n";
    }

    /**
     * Returns a hidden field
     *
     * @param  string $name
     * @param  array  $attributes
     * @return mixed
     */
    public function hidden($name, $attributes = array())
    {
        return $this->input('hidden', $name, $attributes);
    }

    /**
     * Returns a textarea field
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $attributes
     * @return mixed
     */
    public function textarea($name, $value = '', $attributes = array())
    {
        $attr = '';

        if ($attributes) {
            foreach ($attributes as $id => $val) {
                $attr .= $id . '="' . $val . '"' . ' ';
            }
        }

        return '<textarea name="' . $name . '" ' . $attr . '>' . $value . '</textarea' . "\n";
    }

    /**
     * Returns a submit button
     *
     * @param  string $value
     * @param  array  $attributes
     * @return mixed
     */
    public function submit($value, $attributes = array())
    {
        $attr = '';

        if ($attributes) {
            foreach ($attributes as $id => $val) {
                $attr .= $id . '="' . $val . '"' . ' ';
            }
        }

        return '<input type="submit" value="' . $value . '" ' . $attr . '>' . "\n";
    }

    /**
     * Returns a label
     *
     * @param  string $for
     * @param  array  $text
     * @return mixed
     */
    public function label($for, $text)
    {
        return '<label for="' . $for . '">' . $text . '</label>' . "\n";
    }

    /**
     * Returns a closing tag
     *
     * @return mixed
     */
    public function close()
    {
        return '</form>' . "\n";
    }
}