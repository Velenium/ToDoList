<?php

namespace App;

use App\Connect\Connect;
use Ramsey\Uuid\Uuid;

class Options //Service
{
	private $PDO;

	public function __construct()
	{
		$this->PDO = Connect::connect();
	}

	public function addNewTask(String $name, String $body)
	{
		$id = Uuid::uuid4();
		$this->PDO->query("INSERT INTO todo (name, id, body, status) VALUES ('$name', '$id', '$body', 'new')");
		return $id;
	}

	public function makeTaskComplieted(string $id)
	{
		$this->PDO->query("UPDATE todo SET Status = done WHERE (id = '$id')");
	}

	public function deleteTask(string $id)
	{
		$this->PDO->query("DELETE FROM todo WHERE (id = '$id')");
	}

	public function showAll()
	{
		$selection = $this->PDO->query("SELECT * FROM todo");
		$result = $selection->fetchAll(\PDO::FETCH_ASSOC);
		if (empty($result)) {
			print_r('Nothing! Hell Yeah!' . PHP_EOL);
		} else {
			print_r($result);
		}
	}
}