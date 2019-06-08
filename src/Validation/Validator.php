<?php

namespace App\Validation;

use App\ResultConst;

class Validator
{
	private $errors;

	public function validateNewData($name, $body) : Array
	{
		if (!is_string($name)) {
			$this->errors = ResultConst::Validator['101'];
		} elseif (strlen($name) < 3) {
			$this->errors = ResultConst::Task['301']; //ЭТО ВЕДЬ НЕ ЗАДАЧА ВАЛИДАТОРА
		} elseif (!is_string($body)) {
			$this->errors = ResultConst::Validator['102'];
		} elseif (strlen($body) < 3) {
			$this->errors = ResultConst::Task['302']; //ЭТО ВЕДЬ ТОЖЕ НЕ ЗАДАЧА ВАЛИДАТОРА
		}
		
		return $this->errors === null ? [] : $this->errors;
	}

	public function validateUpdateData($id, $newParam) : Array
	{
		$UUIDv4 = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

		if (preg_match($UUIDv4, $id) !== 1)
		{
			$this->errors = ResultConst::Validator['102'];
		}
		if (!is_string($newParam)) {
			$this->errors = ResultConst::Validator['104'];
		}

		return $this->errors === null ? [] : $this->errors;
	}

	public function validateID($id) : Array
	{
		$UUIDv4 = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

		if (preg_match($UUIDv4, $id) !== 1)
		{
			$this->errors = ResultConst::Validator['102'];
		}

		return $this->errors === null ? [] : $this->errors;
	}
}
