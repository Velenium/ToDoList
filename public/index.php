<?php

require __DIR__ . '/../vendor/autoload.php';

use Aura\Router\RouterContainer;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;
use App\TaskController;
use App\Connect\Config;
use App\DependencyContainer;

$config = Config::init();
$di = new DependencyContainer($config);
$controller = $di->getTaskController();

$request = ServerRequestFactory::fromGlobals(
	$_SERVER,
	$_GET,
	$_POST,
	$_COOKIE,
	$_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();
	
$map->post('add.task', '/tasks', function (ServerRequest $request) use ($controller) : Response
{
	return $controller->createNewTask($request);
});

$map->put('set.new.body', '/tasks/{id}/body/update', function (ServerRequest $request) use ($controller) : Response
{
	return $controller->taskBodyUpdate($request);
});

$map->put('set.new.status', '/tasks/{id}/status/update', function (ServerRequest $request) use ($controller) : Response
{
	return $controller->taskStatusUpdate($request);
});

$map->delete('delete.task', '/tasks/{id}', function (ServerRequest $request) use ($controller) : Response
{
	return $controller->taskDelete($request);
});

$map->get('show.task', '/tasks/{id}', function (ServerRequest $request) use ($controller) : Response
{
	return $controller->show($request);
});

$map->get('show.all', '/tasks', function () use ($controller) : Response
{
	return $controller->showAll();
});

$matcher = $routerContainer->getMatcher();

$route = $matcher->match($request);
if (! $route) {
	echo "No route found for the request.";
	exit;
}

foreach ($route->attributes as $key => $val) {
	$request = $request->withAttribute($key, $val);
}

$callable = $route->handler;
$response = $callable($request);

foreach ($response->getHeaders() as $name => $values) {
	foreach ($values as $value) {
		header(sprintf('%s: %s', $name, $value), false);
	}
}
http_response_code($response->getStatusCode());
echo $response->getBody();