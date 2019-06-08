<?php

namespace App;

use Ramsey\Uuid\Uuid;
use App\TaskData;
use App\ResultConst;

class Task
{
	public const MINLENGTH = 3;
	public const POSSIBLESTATUS = ['in progress', 'completed', 'canceled'];

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
		if (strlen($newBody) < self::MINLENGTH) {
			$this->errors = ResultConst::Task['302'];
		} elseif ($this->status === 'completed') {
			$this->errors = ResultConst::Task['303'];
		} elseif ($this->status === 'canceled') {
			$this->errors = ResultConst::Task['304'];
		}

		if (empty($this->errors)) {
			$this->body = $newBody;
		}
	}

	public function taskStatusUpdate(String $newStatus)
	{
		if (!in_array($newStatus, self::POSSIBLESTATUS)) 
		{
			$this->errors = ResultConst::Task['305'];
		} 
		if ($this->status === 'completed' && $newStatus === 'canceled') 
		{
			$this->errors = ResultConst::Task['303'];
		} 
		if ($this->status === 'canceled' && $newStatus === 'completed') 
		{
			$this->errors = ResultConst::Task['304'];
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