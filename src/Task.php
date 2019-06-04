<?php

namespace App;

use Ramsey\Uuid\Uuid;
use App\TaskData;

class Task
{
	private $taskData;

	private function __construct(String $name, Uuid $id, String $body, String $status)
	{
		$this->taskData = new TaskData($name, $id, $body, $status);
	}

	public static function createNewTask(String $name, Uuid $id, String $body, String $status) : self
	{
		return new self($name, $id, $body, $status);
	}

	public static function createFromDTO(TaskData $taskData) : self
	{
		return new self($taskData->name, $taskData->id, $taskData->body, $taskData->status);
	}

	public function taskBodyUpdate(String $newBody)
	{
		$this->taskData->body = $newBody;
	}

	public function taskStatusUpdate(String $newStatus)
	{
		$this->taskData->status = $newStatus;
	}

	public function getTaskData() : TaskData
	{
		return $this->taskData;
	}
}