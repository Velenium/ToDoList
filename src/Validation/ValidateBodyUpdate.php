<?php

namespace App\Validation;

use App\TaskData;

class ValidateBodyUpdate
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
		if ($taskData === null) {
			$this->error = 'Task does not exist';
		} 
		elseif (strlen($taskData->body) < 3) {
			$this->error = 'Minimum body length is 3';
		}
		return $this->error;
	}
}