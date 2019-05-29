<?php

namespace App;

use Ramsey\Uuid\Uuid;
use App\TaskData;

class Task
{
	const MINLENGTH = 3;
	const POSSIBLESTATUS = ['in progress', 'canceled', 'completed'];


	private $taskData;

	public function __construct(String $name, Uuid $id, String $body, String $status)
	{
		$this->taskData = new TaskData($name, $id, $body, $status);
	}

	public static function createNewTask(String $name, String $body)
	{
		if (strlen($name) < self::MINLENGTH) {
			return 'Minimum name length is ' . self::MINLENGTH;
		}
		elseif (strlen($body) < self::MINLENGTH) {
			return 'Minimum body length is ' . self::MINLENGTH;
		}

		$id = Uuid::uuid4();
		$status = 'new';
		return new self($name, $id, $body, $status);
	}

	public static function createFromDTO(TaskData $taskData) : self
	{
		return new self($taskData->name, $taskData->id, $taskData->body, $taskData->status);
	}

	public function taskBodyUpdate(String $newBody)
	{
		if (strlen($newBody < self::MINLENGTH)) {
			return 'Minimum body length is ' . self::MINLENGTH;
		}
		elseif ($this->taskData->status === 'completed') {
			return 'Task already completed';
		}
		elseif ($this->taskData->status === 'canceled') {
			return 'Task already canceled';
		}

		$this->taskData->body = $newBody;
	}

	public function taskStatusUpdate(String $newStatus)
	{
		if (!in_array($newStatus, self::POSSIBLESTATUS)) 
		{
			return 'Expected status: in progress/completed/canceled';
		} 
		elseif ($this->taskData->status === 'completed' && $newStatus === 'canceled') 
		{
			return 'Task already comleted';
		} 
		elseif ($this->taskData->status === 'canceled' && $newStatus === 'completed') 
		{
			return 'Task already canceled';
		}

		$this->taskData->status = $newStatus;
	}

	public function getTaskData() : TaskData
	{
		return $this->taskData;
	}
}