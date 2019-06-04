<?php

namespace App\Validation;

use App\TaskData;

class ValidateToDo
{
	private $error;

	private function __construct()
	{
		$this->error = 'not found';
	}

	public static function init()
	{
		return new self();
	}

	public function validateTable($result)
	{
		return empty($result) ? null : $this->error;
	}
}