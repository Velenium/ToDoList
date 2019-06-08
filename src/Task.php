<?php

namespace App;

use Ramsey\Uuid\Uuid;
use App\TaskData;

class Task
{
	private const MinLength = 3;
	private const PossibleStatus = ['in progress', 'completed', 'canceled'];

	public const Error = [
		'301' => ['error' => 'Minimum name length is 3', 'code' => 411],
		'302' => ['error' => 'Minimum body length is 3', 'code' => 411],
		'303' => ['error' => 'Task Already Completed', 'code' => 409],
		'304' => ['error' => 'Task Already Canceled', 'code' => 409],
		'305' => ['error' => 'Expected status: in progress/completed/canceled', 'code' => 406]
	];

	private $errors;
	private $name;
	private $id;
	private $body;
	private $status;

	private function __construct(
		Array $errors,
		String $name = null, Uuid $id  = null,
		String $body = null, String $status = null)
	{
		$this->errors = $errors;
		$this->name = $name;
		$this->id = $id;
		$this->body = $body;
		$this->status = $status;
	}

	public static function createNewTask(
		Array $errors,
		String $name = null, Uuid $id  = null,
		String $body = null, String $status = null) : self
	{
		return new self([], $name, $id, $body, $status);
	}

	public function taskBodyUpdate(String $newBody)
	{
		if (strlen($newBody) < self::MinLength) {
			$this->errors = self::Error['302'];
		} elseif ($this->status === 'completed') {
			$this->errors = self::Error['303'];
		} elseif ($this->status === 'canceled') {
			$this->errors = self::Error['304'];
		}

		if (empty($this->errors)) {
			$this->body = $newBody;
		}
	}

	public function taskStatusUpdate(String $newStatus)
	{
		if (!in_array($newStatus, self::PossibleStatus)) 
		{
			$this->errors = self::Error['305'];
		} 
		if ($this->status === 'completed' && $newStatus === 'canceled') 
		{
			$this->errors = self::Error['303'];
		} 
		if ($this->status === 'canceled' && $newStatus === 'completed') 
		{
			$this->errors = self::Error['304'];
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