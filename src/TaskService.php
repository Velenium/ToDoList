<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

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

	public function addNewTask(String $name, String $body) : String
	{
		$task = Task::createNewTask($name, $body);
		$taskData = $task->getTaskData();
		$this->repository->create($taskData);
		$id = $task->getTaskData()->id;

		return $id;
	}

	public function updateTaskBody(Uuid $id, String $newBody)
	{
		$givenTaskData = $this->repository->find($id);
		$task = Task::createFromDTO($givenTaskData);
		$task->taskBodyUpdate($newBody);
		$taskData = $task->getTaskData();
		$this->repository->update($taskData);

		return 'Body updated';
	}

		public function updateTaskStatus(Uuid $id, String $newStatus)
	{
		$givenTaskData = $this->repository->find($id);
		$task = Task::createFromDTO($givenTaskData);
		$task->taskStatusUpdate($newStatus);
		$taskData = $task->getTaskData();
		$this->repository->update($taskData);

		return 'Status updated';
	}

	public function deleteTask(Uuid $id)
	{
		$givenTaskData = $this->repository->find($id);
		$task = Task::createFromDTO($givenTaskData);
		$taskData = $task->getTaskData();
		$this->repository->delete($taskData);

		return 'Task deleted';
	}

	public function show(Uuid $id)
	{
		$taskData = $this->repository->find($id);
		$taskData->id->toString();

		return $taskData;
	}

	public function showAll()
	{
		return $this->repository->findAll();
	}
}


//$a = new TaskService();

//print_r($a->addNewTask('second', 'to do'));

//$id = Uuid::FromString("8fd8463a-0000-4418-81a6-d5c78987a913");
//print_r($a->updateTaskBody($id, 'nowdays'));

//print_r($a->updateTaskStatus($id, 'new')); #exception throw
//print_r($a->updateTaskStatus($id, 'in progress'));

//print_r($a->deleteTask($id));

//print_r($a->show($id)); #ну типа работает, только Uuid выводится как говно

//print_r($a->showAll());