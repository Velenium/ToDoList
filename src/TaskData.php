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
		array $errors = [],
		string $name = null, Uuid $id  = null,
		string $body = null, string $status = null)
	{
		$this->errors = $errors;
		$this->name = $name;
		$this->id = $id;
		$this->body = $body;
		$this->status = $status;
	}
}