<?php

namespace App\Connect;

class Config
{
	private $params;

	private function __construct()
	{
		$this->params = parse_ini_file('db_config.ini');

		if ($this->params === false) {
			throw new \Exception("Error reading database configuration file");
		}
	}

	public static function init()
	{
		return new self();
	}

	public function getConnectionString() : string
	{	
		$connectionString = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", 
				$this->params['host'], 
				$this->params['port'], 
				$this->params['database'], 
				$this->params['user'], 
				$this->params['password']);

		return $connectionString;
	}

	public function getOptions() : array
	{
		return $this->params['opt'];
	}
}