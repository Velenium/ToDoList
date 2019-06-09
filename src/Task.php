<?php

namespace App;

use Ramsey\Uuid\Uuid;
use App\TaskData;

class Task
{
	private const MinLength = 3;
	private const PossibleStatus = ['in progress', 'completed', 'canceled'];

	public const Error = [
		'Body Length' => ['body' => 'Minimum body length is 3', 'status' => 'Length Required'],
		'Completed' => ['body' => 'Task Already Completed', 'status' => 'Conflict'],
		'Canceled' => ['body' => 'Task Already Canceled', 'status' => 'Conflict'],
		'Expected' => ['body' => 'Expected Status: in progress/completed/canceled', 'status' => 'Not Acceptable']
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
		if (strlen($newBody) < self::MinLength) {
			$this->errors = self::Error['Body Length'];
		} elseif ($this->status === 'completed') {
			$this->errors = self::Error['Completed'];
		} elseif ($this->status === 'canceled') {
			$this->errors = self::Error['Canceled'];
		}

		if (empty($this->errors)) {
			$this->body = $newBody;
		}
	}

	public function taskStatusUpdate(string $newStatus)
	{
		if (!in_array($newStatus, self::PossibleStatus)) 
		{
			$this->errors = self::Error['Expected'];
		} 
		if ($this->status === 'completed' && $newStatus === 'canceled') 
		{
			$this->errors = self::Error['Completed'];
		} 
		if ($this->status === 'canceled' && $newStatus === 'completed') 
		{
			$this->errors = self::Error['Completed'];
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