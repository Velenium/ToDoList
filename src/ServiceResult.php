<?php

namespace App;

class ServiceResult
{
	private $body;
	private $status;

	public function __construct()
	{
		$this->status = true;
	}

	public function getBody()
	{
		return $this->body;
	}

	public function getStatus() : Bool
	{
		return $this->status;
	}

	public function setBody(Array $body)
	{
		$this->body = $body;
	}

	public function setErrorStatus()
	{
		$this->status = false;
	}
}