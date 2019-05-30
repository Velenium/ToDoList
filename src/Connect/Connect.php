<?php

namespace App\Connect;

class Connect
{
	public function connect() : \PDO
	{
		$connectionString = Config::getConnectionString();
		$options = Config::getOptions();
		return new \PDO($connectionString, null, null, $options);
	}
}