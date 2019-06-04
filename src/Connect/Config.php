<?php

namespace App\Connect;

class Config
{
	private function __construct(){}

	public static function init()
	{
		return new self();
	}

	private function parseConfigFile() : Array
	{
		$params = parse_ini_file('db_config.ini');

		if ($params === false) {
			throw new \Exception("Error reading database configuration file");
		}

		return $params;
	}

	public function getConnectionString() : String
	{
		$params = $this->parseConfigFile();
		
		$connectionString = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", 
				$params['host'], 
				$params['port'], 
				$params['database'], 
				$params['user'], 
				$params['password']);

		return $connectionString;
	}

	public function getOptions() : Array
	{
		$params = $this->parseConfigFile();
		return $params['opt'];
	}
}