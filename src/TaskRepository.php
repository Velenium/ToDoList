<?php

namespace App;

use Ramsey\Uuid\Uuid;
use App\Connect\Connect;
use App\TaskData;


class TaskRepository
{
	private $pdo;

	public function __construct(\PDO $connect)
	{
		$this->pdo = $connect;
	}

	public function find(Uuid $id) : array
	{
		$stringID = $id->toString();
		$stmt = $this->pdo->prepare('SELECT * FROM todo WHERE (id = :id)');
		$stmt->execute([':id' => $stringID]);
		$givenData = $stmt->fetch(\PDO::FETCH_ASSOC);

		return $givenData === false ? [] : $givenData;
	}

	public function findAll() : array
	{
		$stmt = $this->pdo->prepare('SELECT * FROM todo');
		$stmt->execute();
		$dataAll = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		return $dataAll;
	}

	public function create(TaskData $taskData)
	{
		$stmt = $this->pdo->prepare('INSERT INTO todo (name, id, body, status) 
			VALUES (:name, :id, :body, :status)');
		$stmt->execute([':name' => $taskData->name,
						':id' => $taskData->id->toString(),
						':body' => $taskData->body,
						':status' => $taskData->status
		]);
	}

	public function update(TaskData $taskData)
	{
		$stmt = $this->pdo->prepare('UPDATE todo SET name = :name, body = :body, status = :status 
			WHERE (id = :id)');
		$stmt->execute([':name' => $taskData->name,
						':id' => $taskData->id->toString(),
						':body' => $taskData->body,
						':status' => $taskData->status
		]);
	}

	public function delete(TaskData $taskData)
	{
		$stmt = $this->pdo->prepare("DELETE FROM todo WHERE id = :id");
		$stmt->execute([':id' => $taskData->id->toString()]);
	}
}