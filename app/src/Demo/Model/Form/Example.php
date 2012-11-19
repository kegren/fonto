<?php

namespace Demo\Model\Form;

use Fonto\Core\FormModel\Base;
use Fonto\Core\Validation\Validator;

class Example extends Base
{
	/**
	 * Sets rules for 'Example form'
	 *
	 * @param  Validator $validator
	 * @return Closure
	 */
	public function rules(Validator $validator)
	{
		$rules = function() use ($validator) {
			$validator->field('username')
					  ->max(32)
                      ->min(2)
					  ->required();

			$validator->field('password')
					  ->max(32)
					  ->min(8)
					  ->required();
		};

		return $rules();
	}
}