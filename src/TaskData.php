<?php

namespace App;

use Ramsey\Uuid\Uuid;

class TaskData
{
	private $name;
	private $id;
	private $body;
	private $status;

	public function __construct(String $name, Uuid $id, String $body, String $status)
	{
		$this->name = $name;
		$this->id = $id;
		$this->body = $body;
		$this->status = $status;
	}
}