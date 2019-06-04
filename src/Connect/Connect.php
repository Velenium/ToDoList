<?php

namespace App\Connect;

use App\Connect\Config;

class Connect
{
	public function connect() : \PDO
	{
		$config = Config::init();
		$connectionString = $config->getConnectionString();
		$options = $config->getOptions();
		return new \PDO($connectionString, null, null, $options);
	}
}