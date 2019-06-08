<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response;
use App\Validation\Validator;
use App\ResultConst;
use App\Task;
use App\TaskData;
use App\TaskRepository;
use App\ServiceResult;

class TaskService
{
	private $repository;
	private $serviceResult;

	public function __construct()
	{
		$this->repository = new TaskRepository();
		$this->serviceResult = new ServiceResult();
		$this->validator = new Validator();
	}

	public function createNewTask($name, $body) : ServiceResult
	{
		$errors = $this->validator->validateNewData($name, $body);
		if (!empty($errors)) {
			$this->serviceResult->setBody($errors);
			$this->serviceResult->setErrorStatus();
			return $this->serviceResult;
		}

		$id = Uuid::uuid4();
		$status = 'new';
		$task = Task::createNewTask([], $name, $id, $body, $status);
		$taskData = $task->getTaskData();
		$this->repository->create($taskData);
		$this->serviceResult->setBody(ResultConst::Result['001']);

		return $this->serviceResult;
	}

	public function taskBodyUpdate($id, $newBody) : ServiceResult
	{
		$errors = $this->validator->validateUpdateData($id, $newBody);
		if (!empty($errors)) {
			$this->serviceResult->setBody($errors);
			$this->serviceResult->setErrorStatus();
			return $this->serviceResult;
		}
		
		$id = Uuid::FromString($id);
		$givenData = $this->repository->find($id);
		if (empty($givenData)) {
			$this->serviceResult->setBody(ResultConst::Repository['201']);
			$this->serviceResult->setErrorStatus();
			return $this->serviceResult;
		}

		$task = Task::createNewTask(
			[], $givenData['name'], Uuid::FromString($givenData['id']),
			$givenData['body'], $givenData['status']
		);
		$task->taskBodyUpdate($newBody);
		$taskData = $task->getTaskData();

		$errors = $taskData->errors;
		if (!empty($errors)) {
			$this->serviceResult->setBody($errors);
			$this->serviceResult->setErrorStatus();
			return $this->serviceResult;
		}

		$this->repository->update($taskData);
		$this->serviceResult->setBody(ResultConst::Result['002']);

		return $this->serviceResult;
	}

	public function taskStatusUpdate($id, $newStatus) : ServiceResult
	{
		$errors = $this->validator->validateUpdateData($id, $newStatus);
		if (!empty($errors)) {
			$this->serviceResult->setBody($errors);
			$this->serviceResult->setErrorStatus();
			return $this->serviceResult;
		}

		$id = Uuid::FromString($id);
		$givenData = $this->repository->find($id);
		if (empty($givenData)) {
			$this->serviceResult->setBody(ResultConst::Repository['201']);
			$this->serviceResult->setErrorStatus();
			return $this->serviceResult;
		}

		$task = Task::createNewTask(
			[], $givenData['name'], Uuid::FromString($givenData['id']),
			$givenData['body'], $givenData['status']
		);
		$task->taskStatusUpdate($newStatus);
		$taskData = $task->getTaskData();
		$errors = $taskData->errors;
		if (!empty($errors)) {
			$this->serviceResult->setBody($errors);
			$this->serviceResult->setErrorStatus();
			return $this->serviceResult;
		}

		$this->repository->update($taskData);
		$this->serviceResult->setBody(ResultConst::Result['003']);

		return $this->serviceResult;
	}

	public function taskDelete($id) : ServiceResult
	{
		$errors = $this->validator->validateID($id);
		if (!empty($errors)) {
			$this->serviceResult->setBody($errors);
			$this->serviceResult->setErrorStatus();
			return $this->serviceResult;
		}

		$id = Uuid::FromString($id);
		$givenData = $this->repository->find($id);
		if (empty($givenData)) {
			$this->serviceResult->setBody(ResultConst::Repository['201']);
			$this->serviceResult->setErrorStatus();
			return $this->serviceResult;
		}

		$task = Task::createNewTask(
			[], $givenData['name'], Uuid::FromString($givenData['id']),
			$givenData['body'], $givenData['status']
		);
		$taskData = $task->getTaskData();
		$errors = $taskData->errors;
		if (!empty($errors)) {
			$this->serviceResult->setBody($errors);
			$this->serviceResult->setErrorStatus();
			return $this->serviceResult;
		}

		$this->repository->delete($taskData);
		$this->serviceResult->setBody(ResultConst::Result['004']);

		return $this->serviceResult;
	}

	public function show($id) : ServiceResult
	{
		$errors = $this->validator->validateID($id);
		if (!empty($errors)) {
			$this->serviceResult->setBody($errors);
			$this->serviceResult->setErrorStatus();
			return $this->serviceResult;
		}

		$id = Uuid::FromString($id);
		$givenData = $this->repository->find($id);
		if (empty($givenData)) {
			$this->serviceResult->setBody(ResultConst::Repository['201']);
			$this->serviceResult->setErrorStatus();
			return $this->serviceResult;
		}

		$result['result'] = $givenData;
		$result['code'] = 200;

		$this->serviceResult->setBody($result);

		return $this->serviceResult;
	}

	public function showAll() : ServiceResult
	{
		$givenData = $this->repository->findAll();
		if (empty($givenData)) {
			$this->serviceResult->setBody(ResultConst::Result['005']);
			return $this->serviceResult;
		}

		$result['result'] = $givenData;
		$result['code'] = 200;

		$this->serviceResult->setBody($result);

		return $this->serviceResult;
	}
}