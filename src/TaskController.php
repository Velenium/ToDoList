<?php

namespace App;

use App\TaskService;
use Zend\Diactoros\ServerRequest;
use Ramsey\Uuid\Uuid;

class TaskController
{
	private $service;

	public function __construct()
	{
		$this->service = new TaskService();
	}

	public function createNewTask(ServerRequest $request) : String
	{	
		$name = $request->getQueryParams()['name'];
		$body = $request->getQueryParams()['body'];
		$result = $this->service->createNewTask($name, $body);

		return json_encode($result);
	}

	public function taskBodyUpdate(ServerRequest $request) : String
	{
		$id = Uuid::FromString($request->getAttribute('id'));
		$newBody = $request->getQueryParams()['body'];
		$result = $this->service->taskBodyUpdate($id, $newBody);

		return json_encode($result);
	}

	public function taskStatusUpdate(ServerRequest $request) : String
	{
		$id = Uuid::FromString($request->getAttribute('id'));
		$newStatus = $request->getQueryParams()['status'];
		$result = $this->service->taskStatusUpdate($id, $newStatus);

		return json_encode($result);
	}

	public function taskDelete(ServerRequest $request) : String
	{
		$id = Uuid::FromString($request->getAttribute('id'));
		$result = $this->service->taskDelete($id);

		return json_encode($result);
	}

	public function show(ServerRequest $request) : String
	{
		$id = Uuid::FromString($request->getAttribute('id'));
		$result = $this->service->show($id);

		return json_encode($result);
	}

	public function showAll() : String
	{
		return json_encode($this->service->showAll());
	}
}