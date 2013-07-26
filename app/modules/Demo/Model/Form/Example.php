<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Demo\Model\Form;

use Fonto\FormModel\Base;

/**
 * A basic example how a form model can look like.
 *
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Example extends Base
{
    /**
     * Sets rules for example form
     *
     * @return array
     */
    public function rules()
    {
        return array(
            'username' => 'max{5}|min{2}|required',
            'password' => 'max{32}|min{8}|identical{username}|required',
            'email' => 'email|required'
        );
    }
}