<?php

namespace App\Validation;

use App\TaskData;

class ValidateStatusUpdate
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

	public function validateNewStatus(String $newStatus, String $oldStatus)
	{
		$possibleStatus = ['in progress', 'canceled', 'completed'];

		if (!in_array($newStatus, $possibleStatus)) 
		{
			$this->error = 'Expected status: in progress/completed/canceled';
		} 
		elseif (($newStatus === 'completed' || $newStatus === 'canceled') && $oldStatus === 'canceled')
		{
			$this->error = 'Task already canceled';
		}
		elseif (($newStatus === 'completed' || $newStatus === 'canceled') && $oldStatus === 'completed')
		{
			$this->error = 'Task already completed';
		}
	}
}