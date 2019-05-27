<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use App\Connect\Connect;
use App\TaskData;


class TaskRepository
{
	private $pdo;

	public function __construct()
	{
		$this->pdo = Connect::connect();
	}

	public function find($id) : TaskData
	{
		$stmt = $this->pdo->prepare('SELECT * FROM todo WHERE (id = :id)');
		$stmt->execute([':id' => $id]);
		$data = $stmt->fetch(\PDO::FETCH_ASSOC);
		$taskData = new TaskData(
			$data['name'],
			Uuid::FromString($data['id']),
			$data['body'],
			$data['status']);

		return $taskData;
	}

	public function findAll() : Array
	{
		$stmt = $this->pdo->prepare('SELECT * FROM todo');
		$stmt->execute();
		$taskDataAll = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		return $taskDataAll;
	}

	public function create($taskData)
	{
		$stmt = $this->pdo->prepare('INSERT INTO todo (name, id, body, status) 
			VALUES (:name, :id, :body, :status)');
		$stmt->execute([':name' => $taskData->name,
						':id' => $taskData->id->toString(),
						':body' => $taskData->body,
						':status' => $taskData->status
		]);
	}

	public function update($taskData)
	{
		$stmt = $this->pdo->prepare('UPDATE todo SET name = :name, body = :body, status = :status 
			WHERE (id = :id)');
		$stmt->execute([':name' => $taskData->name,
						':id' => $taskData->id->toString(),
						':body' => $taskData->body,
						':status' => $taskData->status
		]);
	}

	public function delete($taskData)
	{
		$stmt = $this->pdo->prepare("DELETE FROM todo WHERE id = :id");
		$stmt->execute([':id' => $taskData->id->toString()]);
	}
}