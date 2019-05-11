<?php

require 'db_connect.php';

use Ramsey\Uuid\Uuid;

class Options //Service
{
	private $PDO;

	public function __construct()
	{
		$this->PDO = DataBase::connect();
	}

	public function add(string $text)
	{
		$id = Uuid::uuid4();
		$this->PDO->query("INSERT INTO todo (task_name, task_id) VALUES ('$text', '$id')");
	}

	public function complete(string $id)
	{
		$this->PDO->query("UPDATE todo SET accomplishment = true, acc_date = now() WHERE (task_id = '$id')");
	}

	public function delete(string $id)
	{
		$this->PDO->query("DELETE FROM todo WHERE (task_id = '$id')");
	}

	public function show()
	{
		$selection = $this->PDO->query("SELECT task_name, task_id, creation_date, accomplishment, acc_date FROM todo");
		$result = $selection->fetchAll(PDO::FETCH_ASSOC);
		if (empty($result)) {
			print_r('Nothing! Hell Yeah!' . PHP_EOL);
		} else {
			print_r($result);
		}
	}
}