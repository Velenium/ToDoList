<?php

namespace App\Validation;

class Validator
{
	private $errors;

	private const UUIDv4 = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

	private const Error = [
		'101' => ['error' => 'Invalid Name Given', 'code' => 400], 
 		'102' => ['error' => 'Invalid Body Given', 'code' => 400],
 		'103' => ['error' => 'Invalid Task ID Given', 'code' => 400],
		'104' => ['error' => 'Invalid Param Given', 'code' => 400],
		'105' => ['error' => 'Minimum name length is 3', 'code' => 411],
		'106' => ['error' => 'Minimum body length is 3', 'code' => 411],
	];

	public function validateNewData($name, $body) : Array
	{
		if (!is_string($name)) {
			$this->errors = self::Error['101'];
		} elseif (strlen($name) < 3) {
			$this->errors = self::Error['105'];
		} elseif (!is_string($body)) {
			$this->errors = self::Error['102'];
		} elseif (strlen($body) < 3) {
			$this->errors = self::Error['106'];
		}
		
		return $this->errors === null ? [] : $this->errors;
	}

	public function validateUpdateData($id, $newParam) : Array
	{
		if (preg_match(self::UUIDv4, $id) !== 1)
		{
			$this->errors = self::Error['102'];
		}
		if (!is_string($newParam)) {
			$this->errors = self::Error['104'];
		}

		return $this->errors === null ? [] : $this->errors;
	}

	public function validateID($id) : Array
	{
		if (preg_match(self::UUIDv4, $id) !== 1)
		{
			$this->errors = self::Error['102'];
		}

		return $this->errors === null ? [] : $this->errors;
	}
}
