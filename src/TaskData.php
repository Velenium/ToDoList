<?php

namespace App;

use Ramsey\Uuid\Uuid;

class TaskData
{
	public $errors;
	public $name;
	public $id;
	public $body;
	public $status;

	public function __construct(
		Array $errors = [],
		String $name = null, Uuid $id  = null,
		String $body = null, String $status = null)
	{
		$this->errors = $errors;
		$this->name = $name;
		$this->id = $id;
		$this->body = $body;
		$this->status = $status;
	}
}