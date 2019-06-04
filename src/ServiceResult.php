<?php

namespace App;

class ServiceResult
{
	private $status;
	private $body;

	public function __construct()
	{
		$this->status = '200';
	}

	public function getBody()
	{
		return $this->body;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setResponseBody($body)
	{
		$this->body = $body;
	}

	public function setResponseStatusError()
	{
		switch ($this->body) {
			case 'Minimum name length is 3' : 
				$this->status = '411';
				break;
			case 'Minimum body length is 3' :
				$this->status = '411';
				break;
			case 'Task does not exist' :
				$this->status = '404';
				break;
			case 'Expected status: in progress/completed/canceled' :
				$this->status = '406';
				break;
			case 'Task already canceled' :
				$this->status = '409';
				break;
			case 'Task already completed' :
				$this->status = '409';
				break;
			case null :
				$this->status = '204';
				break;
		}
	}
}