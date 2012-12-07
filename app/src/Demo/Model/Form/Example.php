<?php

namespace Demo\Model\Form;

use Fonto\Core\FormModel\Base;

class Example extends Base
{
    /**
     * @return array
     */
    public function rules()
    {
        return array(
            'username' => 'max{5}|min{2}|required|email',
            'password' => 'max{32}|min{8}|identical{username}|required',
        );
    }
}