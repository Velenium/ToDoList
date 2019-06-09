<?php

namespace App;

use Ramsey\Uuid\Uuid;
use App\TaskData;

class Task
{
	private const MINLENGTH = 3;
	private const POSSIBLESTATUS = ['in progress', 'completed', 'canceled'];

	private const ERRORSTATUS = 'Bad Request';

	private const ERRORBODY = [
		'Body Length' => 'Minimum body length is 3',
		'Completed' => 'Task Already Completed',
		'Canceled' => 'Task Already Canceled',
		'Expected' => 'Expected status: in progress/completed/canceled',
	];

	private $errors;
	private $name;
	private $id;
	private $body;
	private $status;

	private function __construct(
		array $errors,
		string $name = null, Uuid $id  = null,
		string $body = null, string $status = null)
	{
		$this->errors = $errors;
		$this->name = $name;
		$this->id = $id;
		$this->body = $body;
		$this->status = $status;
	}

	public static function createNewTask(
		array $errors,
		string $name = null, Uuid $id  = null,
		string $body = null, string $status = null) : self
	{
		return new self([], $name, $id, $body, $status);
	}

	public function taskBodyUpdate(string $newBody)
	{
		 if ($this->status === 'completed') {
			$this->errors = self::ERROR['Completed'];
		} elseif ($this->status === 'canceled') {
			$this->errors = self::ERROR['Canceled'];
		} elseif (strlen($newBody) < self::MINLENGTH) {
			$this->errors = self::ERROR['Body Length'];
		}

		if (empty($this->errors)) {
			$this->body = $newBody;
		}
	}

	public function taskStatusUpdate(string $newStatus)
	{
		if (!in_array($newStatus, self::POSSIBLESTATUS)) 
		{
			$this->errors = self::ERROR['Expected'];
		} 
		if ($this->status === 'completed' && $newStatus === 'canceled') 
		{
			$this->errors = self::ERROR['Completed'];
		} 
		if ($this->status === 'canceled' && $newStatus === 'completed') 
		{
			$this->errors = self::ERROR['Canceled'];
		}
		if (empty($this->errors)) {
			$this->status = $newStatus;
		}
	}

	public function getTaskData() : TaskData
	{
		return new TaskData($this->errors, $this->name, $this->id, $this->body, $this->status);
	}
}