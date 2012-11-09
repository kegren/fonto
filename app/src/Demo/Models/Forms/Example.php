<?php

namespace Demo\Models\Forms;

use Fonto\Core\FormModel\Base;
use Fonto\Core\Validation\Validator;

class Example extends Base
{
	public function rules(Validator $validator)
	{
		$rules = function() use ($validator) {
			$validator->field('username')
					   ->max(4)
					   ->num()
					   ->required();

			$validator->field('password')
					   ->max(3)
					   ->required();
		};

		return $rules();
	}
}