<?php

namespace Validator;

class Validator {

	public function validate($type, $value, $param=null) {
		$isValid = null;
		switch($type) {
			case 'string':
				$isValid = is_string($value);
				break;
			case 'maxLength':
				$isValid = strlen($value) <= $param;
				break;
			case 'required':
				$isValid = !empty($value);
				break;
			default:
				throw new ValidatorException('unknown type: ' . var_export($type,1));
		}
		return $isValid;
	}

}
