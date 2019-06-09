<?php

namespace App;

class ServiceResult
{
	private $body;
	private $status;

	public function getBody() : string
	{
		return $this->body;
	}

	public function getStatus() : string
	{
		return $this->status;
	}

	public function formResult(array $result)
	{
		$this->status = $result['status'];
		$this->body = json_encode($result['body']);
	}
}