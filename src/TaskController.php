<?php

namespace App;

use App\TaskService;
use App\ServiceResult;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;
use Ramsey\Uuid\Uuid;

class TaskController
{
	private $service;

	public function __construct()
	{
		$this->service = new TaskService();
	}

	private function formResponse(ServiceResult $serviceResult) : Response
	{
		$status = $serviceResult->getStatus();
		$body = $serviceResult->getBody();

		$response = new Response();

		if ($status) {
			$response->getBody()->write(json_encode($body['result']));
			$response = $response->withStatus($body['code']);
		} else {
			$response->getBody()->write(json_encode($body['error']));
			$response = $response->withStatus($body['code']);
		}

		return $response;
	}

	public function createNewTask(ServerRequest $request) : Response
	{
		$name = $request->getQueryParams()['name'];
		$body = $request->getQueryParams()['body'];
		
		$result = $this->service->createNewTask($name, $body);
		$response = $this->formResponse($result);

		return $response;
	}

	public function taskBodyUpdate(ServerRequest $request) : Response
	{
		$id = $request->getAttribute('id');
		$newBody = $request->getQueryParams()['body'];

		$result = $this->service->taskBodyUpdate($id, $newBody);
		$response = $this->formResponse($result);

		return $response;
	}

	public function taskStatusUpdate(ServerRequest $request) : Response
	{
		$id = $request->getAttribute('id');
		$newStatus = $request->getQueryParams()['status'];

		$result = $this->service->taskStatusUpdate($id, $newStatus);
		$response = $this->formResponse($result);

		return $response;
	}

	public function taskDelete(ServerRequest $request) : Response
	{
		$id = $request->getAttribute('id');

		$result = $this->service->taskDelete($id);
		$response = $this->formResponse($result);

		return $response;
	}

	public function show(ServerRequest $request) : Response
	{
		$id = $request->getAttribute('id');

		$result = $this->service->show($id);
		$response = $this->formResponse($result);

		return $response;
	}

	public function showAll() : Response
	{
		$result = $this->service->showAll();
		$response = $this->formResponse($result);

		return $response;
	}
}