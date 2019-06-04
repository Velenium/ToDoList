<?php

namespace App\Validation;

use App\TaskData;

class ValidateCreation
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

	public function validateDTO(TaskData $taskData) : String
	{
		$name = $taskData->name;
		$body = $taskData->body;

		if (strlen($name) < 3) {
			$this->error = 'Minimum name length is 3';
		} 
		elseif (strlen($body) < 3) {
			$this->error = 'Minimum body length is 3';
		}
		return $this->error;
	}
}