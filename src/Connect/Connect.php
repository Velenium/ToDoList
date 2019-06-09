<?php

namespace App\Connect;

use App\Connect\Config;

class Connect
{
	private $connect;

	public function __construct(string $connectString, array $options)
	{	
		$this->connect = new \PDO($connectString, null, null, $options);
	}

	public function getConnection() : \PDO
	{
		return $this->connect;
	}
}