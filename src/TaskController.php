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

	private const ResponseCode = [
		'OK' => 200,
		'Bad Request' => 400,
		'Not Found' => 404,
		'Not Acceptable' => 406,
		'Conflict' => 409,
		'Length Required' => 411
	];

	public function __construct(TaskService $service)
	{
		$this->service = $service;
	}

	private function formResponse(ServiceResult $serviceResult) : Response
	{
		$resultStatus = $serviceResult->getStatus();
		
		$status = self::ResponseCode[$resultStatus];
		$body = $serviceResult->getBody();

		$response = new Response();

		$response->getBody()->write($body);
		$response = $response->withStatus($status);

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