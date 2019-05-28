<?php

namespace App;

use Ramsey\Uuid\Uuid;
use App\TaskData;

class Task
{
	private $taskData;

	public function __construct(String $name, Uuid $id, String $body, String $status)
	{
		$this->taskData = new TaskData($name, $id, $body, $status);
	}

	public static function createNewTask(String $name, String $body)
	{
		$minLength = 3; //вынести в константу

		if (strlen($name) < $minLength) {
			return 'Minimum name length is 3';
		}
		elseif (strlen($body) < $minLength) {
			return 'Minimum body length is 3';
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
		$minLength = 3; //вынести в константу

		if (strlen($newBody < $minBodyLength)) {
			return 'Minimum body length is 3';
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
		$possibleStatuses = ['in progress', 'completed', 'canceled'];

		if (!in_array($newStatus, $possibleStatuses)) 
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