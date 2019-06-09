<?php

namespace App\Validation;

class Validator
{
	private $errors;

	private const UUIDv4 = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

	private const Error = [
		'Name' => ['body' => 'Invalid Name Given', 'status' => 'Bad Request'], 
 		'Body' => ['body' => 'Invalid Body Given', 'status' => 'Bad Request'],
 		'ID' => ['body' => 'Invalid Task ID Given', 'status' => 'Bad Request'],
		'Param' => ['body' => 'Invalid Param Given', 'status' => 'Bad Request'],
		'Name Length' => ['body' => 'Minimum name length is 3', 'status' => 'Length Required'],
		'Body Length' => ['body' => 'Minimum body length is 3', 'status' => 'Length Required'],
	];

	public function validateNewData($name, $body) : array
	{
		if (!is_string($name)) {
			$this->errors = self::Error['Name'];
		} elseif (strlen($name) < 3) {
			$this->errors = self::Error['Name Length'];
		} elseif (!is_string($body)) {
			$this->errors = self::Error['Body'];
		} elseif (strlen($body) < 3) {
			$this->errors = self::Error['Body Length'];
		}
		
		return $this->errors === null ? [] : $this->errors;
	}

	public function validateUpdateData($id, $newParam) : array
	{
		if (preg_match(self::UUIDv4, $id) !== 1)
		{
			$this->errors = self::Error['ID'];
		}
		if (!is_string($newParam)) {
			$this->errors = self::Error['Param'];
		}

		return $this->errors === null ? [] : $this->errors;
	}

	public function validateID($id) : array
	{
		if (preg_match(self::UUIDv4, $id) !== 1)
		{
			$this->errors = self::Error['ID'];
		}

		return $this->errors === null ? [] : $this->errors;
	}
}
