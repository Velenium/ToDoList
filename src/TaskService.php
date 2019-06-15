<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response;
use App\Validation\Validator;
use App\Task;
use App\TaskData;
use App\TaskRepository;
use App\ServiceResult;

class TaskService
{
	private $repository;
	private $serviceResult;
	private $validator;

	private const RESULT = [
		'Created' => ['body' => 'Task Created!', 'status' => 'OK'],
		'Body Updated' => ['body' => 'Body Updated!', 'status' => 'OK'],
		'Status Updated' => ['body' => 'Status Updated!', 'status' => 'OK'],
		'Deleted' => ['body' => 'Task Deleted!', 'status' => 'OK'],
		'Empty' => ['body' => 'Nothing to do!', 'status' => 'OK'],
		'Not Found' => ['body' => 'Task Not Found', 'status' => 'Not Found']
	];

	public function __construct(TaskRepository $repository, Validator $validator, ServiceResult $serviceResult)
	{
		$this->repository = $repository;
		$this->serviceResult = $serviceResult;
		$this->validator = $validator;
	}

	public function createNewTask($name, $body) : ServiceResult
	{
		$errors = $this->validator->validateNewData($name, $body);
		if (!empty($errors)) {
			$this->serviceResult->formResult($errors);
			return $this->serviceResult;
		}

		$id = Uuid::uuid4();
		$status = 'new';
		$task = Task::createNewTask([], $name, $id, $body, $status);
		$taskData = $task->getTaskData();
		$this->repository->create($taskData);
		$this->serviceResult->formResult('Created!');

		return $this->serviceResult;
	}

	public function taskBodyUpdate($id, $newBody) : ServiceResult
	{
		$errors = $this->validator->validateUpdateData($id, $newBody);
		if (!empty($errors)) {
			$this->serviceResult->formResult($errors);
			return $this->serviceResult;
		}
		
		$id = Uuid::FromString($id);
		$givenData = $this->repository->find($id);
		if (empty($givenData)) {
			$this->serviceResult->formResult(self::RESULT['Not Found']);
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
			$this->serviceResult->formResult($errors);
			return $this->serviceResult;
		}

		$this->repository->update($taskData);
		$this->serviceResult->formResult(self::RESULT['Body Updated']);

		return $this->serviceResult;
	}

	public function taskStatusUpdate($id, $newStatus) : ServiceResult
	{
		$errors = $this->validator->validateUpdateData($id, $newStatus);
		if (!empty($errors)) {
			$this->serviceResult->formResult($errors);
			return $this->serviceResult;
		}

		$id = Uuid::FromString($id);
		$givenData = $this->repository->find($id);
		if (empty($givenData)) {
			$this->serviceResult->formResult(self::RESULT['Not Found']);
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
			$this->serviceResult->formResult($errors);
			return $this->serviceResult;
		}

		$this->repository->update($taskData);
		$this->serviceResult->formResult(self::RESULT['Status Updated']);

		return $this->serviceResult;
	}

	public function taskDelete($id) : ServiceResult
	{
		$errors = $this->validator->validateID($id);
		if (!empty($errors)) {
			$this->serviceResult->formResult($errors);
			return $this->serviceResult;
		}

		$id = Uuid::FromString($id);
		$givenData = $this->repository->find($id);
		if (empty($givenData)) {
			$this->serviceResult->formResult(self::RESULT['Not Found']);
			return $this->serviceResult;
		}

		$task = Task::createNewTask(
			[], $givenData['name'], Uuid::FromString($givenData['id']),
			$givenData['body'], $givenData['status']
		);
		$taskData = $task->getTaskData();
		$errors = $taskData->errors;
		if (!empty($errors)) {
			$this->serviceResult->formResult($errors);
			return $this->serviceResult;
		}

		$this->repository->delete($taskData);
		$this->serviceResult->formResult(self::RESULT['Deleted']);

		return $this->serviceResult;
	}

	public function show($id) : ServiceResult
	{
		$errors = $this->validator->validateID($id);
		if (!empty($errors)) {
			$this->serviceResult->formResult($errors);
			return $this->serviceResult;
		}

		$id = Uuid::FromString($id);
		$givenData = $this->repository->find($id);
		if (empty($givenData)) {
			$this->serviceResult->formResult(self::RESULT['Not Found']);
			return $this->serviceResult;
		}

		$result['body'] = $givenData;
		$result['status'] = 'OK';

		$this->serviceResult->formResult($result);

		return $this->serviceResult;
	}

	public function showAll() : ServiceResult
	{
		$givenData = $this->repository->findAll();
		if (empty($givenData)) {
			$this->serviceResult->formResult(self::RESULT['Empty']);
			return $this->serviceResult;
		}

		$result['body'] = $givenData;
		$result['status'] = 'OK';

		$this->serviceResult->formResult($result);

		return $this->serviceResult;
	}
}