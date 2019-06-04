<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response;
use App\Task;
use App\TaskData;
use App\TaskRepository;
use App\Validation\ValidateCreation;
use App\Validation\ValidateDeletion;
use App\Validation\ValidateBodyUpdate;
use App\Validation\ValidateStatusUpdate;
use App\Validation\ValidateTaskData;
use App\Validation\ValidateToDo;
use App\ServiceResult;

class TaskService
{
	private $repository;
	private $serviceResult;

	public function __construct()
	{
		$this->repository = new TaskRepository();
		$this->serviceResult = new ServiceResult();
	}

	public function createNewTask(String $name, String $body) : ServiceResult
	{
		$id = Uuid::uuid4();
		$status = 'new';
		$task = Task::createNewTask($name, $id, $body, $status);
		$taskData = $task->getTaskData();

		$validator = ValidateCreation::init();
		$error = $validator->validateDTO($taskData);

		if ($error === 'not found') {
			$this->repository->create($taskData);
			$this->serviceResult->setResponseBody($taskData->id);
		} else {
			$this->serviceResult->setResponseBody($error);
			$this->serviceResult->setResponseStatusError();
		}

		return $this->serviceResult;
	}

	public function taskBodyUpdate(Uuid $id, String $newBody) : ServiceResult
	{
		$givenTaskData = $this->repository->find($id);
		$task = Task::createFromDTO($givenTaskData);
		$task->taskBodyUpdate($newBody);
		$taskData = $task->getTaskData();

		$validator = ValidateBodyUpdate::init();
		$error = $validator->validateDTO($taskData);

		if ($error === 'not found') {
			$this->repository->update($taskData);
			$this->serviceResult->setResponseBody('Body updated!');
		} else {
			$this->serviceResult->setResponseBody($error);
			$this->serviceResult->setResponseStatusError();
		}

		return $this->serviceResult;
	}

		public function taskStatusUpdate(Uuid $id, String $newStatus) : ServiceResult
	{
		$givenTaskData = $this->repository->find($id);
		$task = Task::createFromDTO($givenTaskData);
		$oldStatus = $task->getTaskData()->status;

		$validator = ValidateStatusUpdate::init();
		$validator->validateNewStatus($newStatus, $oldStatus);
		$task->taskStatusUpdate($newStatus);
		$taskData = $task->getTaskData();
		$error = $validator->validateDTO($taskData);

		if ($error === 'not found') {
			$this->repository->update($taskData);
			$this->serviceResult->setResponseBody('Status updated!');
		} else {
			$this->serviceResult->setResponseBody($error);
			$this->serviceResult->setResponseStatusError();
		}

		return $this->serviceResult;
	}

	public function taskDelete(Uuid $id) : ServiceResult
	{
		$givenTaskData = $this->repository->find($id);
		$task = Task::createFromDTO($givenTaskData);
		$taskData = $task->getTaskData();

		$validator = ValidateTaskData::init();
		$error = $validator->validateDTO($taskData);

		if ($error === 'not found') {
			$this->repository->delete($taskData);
			$this->serviceResult->setResponseBody('Task Deleted!');
		} else {
			$this->serviceResult->setResponseBody($error);
			$this->serviceResult->setResponseStatusError();
		}

		return $this->serviceResult;
	}

	public function show(Uuid $id) : ServiceResult
	{
		$givenTaskData = $this->repository->find($id);
		$task = Task::createFromDTO($givenTaskData);
		$taskData = $task->getTaskData();

		$validator = ValidateTaskData::init();
		$error = $validator->validateDTO($taskData);

		if ($error === 'not found') {
			$this->serviceResult->setResponseBody($taskData);
		} else {
			$this->serviceResult->setResponseBody($error);
			$this->serviceResult->setResponseStatusError();
		}

		return $this->serviceResult;
	}

	public function showAll() : ServiceResult
	{
		$result = $this->repository->findAll();
		$validator = ValidateToDo::init();
		$error = $validator->validateTable($result);

		if ($error === 'not found') {
			$this->serviceResult->setResponseBody($result);
		} else {
			$this->serviceResult->setResponseBody($error);
			$this->serviceResult->setResponseStatusError();
		}

		return $this->serviceResult;
	}
}