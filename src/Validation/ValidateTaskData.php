<?php

namespace App\Validation;

use App\TaskData;

class ValidateTaskData
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

	public function validateDTO($taskData) : String
	{
		return ($taskData === null) ? 'Task does not exist' : $this->error;
	}
}