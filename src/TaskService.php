<?php

namespace App;

use Ramsey\Uuid\Uuid;
use App\Task;
use App\TaskData;
use App\TaskRepository;

class TaskService
{
	private $repository;

	public function __construct()
	{
		$this->repository = new TaskRepository();
	}

	public function createNewTask(String $name, String $body) : String
	{
		$task = Task::createNewTask($name, $body);

		if (is_string($task)) {
			return $task;
		}

		$taskData = $task->getTaskData();
		$this->repository->create($taskData);
		$id = $task->getTaskData()->id;

		return $id;
	}

	public function taskBodyUpdate(Uuid $id, String $newBody) : String
	{
		$givenTaskData = $this->repository->find($id);
		$task = Task::createFromDTO($givenTaskData);
		$bodyError = $task->taskBodyUpdate($newBody);

		if ($bodyError !== null) {
			return $bodyError;
		}

		$taskData = $task->getTaskData();
		$this->repository->update($taskData);

		return 'Body updated';
	}

		public function taskStatusUpdate(Uuid $id, String $newStatus) : String
	{
		$givenTaskData = $this->repository->find($id);
		$task = Task::createFromDTO($givenTaskData);
		$statusError = $task->taskStatusUpdate($newStatus);

		if ($statusError !== null) {
			return $statusError;
		}

		$taskData = $task->getTaskData();
		$this->repository->update($taskData);

		return 'Status updated';
	}

	public function taskDelete(Uuid $id) : String
	{
		$givenTaskData = $this->repository->find($id);
		$task = Task::createFromDTO($givenTaskData);
		$taskData = $task->getTaskData();
		$this->repository->delete($taskData);

		return 'Task deleted';
	}

	public function show(Uuid $id) : TaskData
	{
		$taskData = $this->repository->find($id);
		$taskData->id->toString();

		return $taskData;
	}

	public function showAll() : Array
	{
		return $this->repository->findAll();
	}
}