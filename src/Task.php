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

	public static function createNewTask(String $name, String $body) : self
	{
		$id = Uuid::uuid4();
		$status = 'new';
		return new self($name, $id, $body, $status);
	}

	public static function createFromDTO(Task $object)
	{
		return new self($object->name, $object->id, $object->body, $object->status);
	}

	public function taskStatusUpdate()
	{
		$possibleStatuses = ['in progress', 'complited'];

		if ($this->taskData->status === 'complited')
		{
			throw new \Exeption('Task already comlited');
		}

		$this->taskData->status = 'in progress';
	}

	public function getUpdatedTask()
	{
		return $this->taskData;
	}
}