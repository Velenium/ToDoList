<?php

require __DIR__ . '/../vendor/autoload.php';

use Aura\Router\RouterContainer;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;
use App\TaskController;

$controller = new TaskController();

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
    $result = $controller->createNewTask($request);
    $response = new Response();
    $response->getBody()->write($result); 

    return $response;
});

$map->put('set.new.body', '/tasks/{id}/body/update', function (ServerRequest $request) use ($controller) : Response
{
    $result = $controller->taskBodyUpdate($request);
    $response = new Response();
    $response->getBody()->write($result); 

    return $response;
});

$map->put('set.new.status', '/tasks/{id}/status/update', function (ServerRequest $request) use ($controller) : Response
{
    $result = $controller->taskStatusUpdate($request);
    $response = new Response();
    $response->getBody()->write($result); 

    return $response;
});

$map->delete('delete.task', '/tasks/{id}', function (ServerRequest $request) use ($controller) : Response
{
    $result = $controller->taskDelete($request);
    $response = new Response();
    $response->getBody()->write($result); 

    return $response;
});

$map->get('show.task', '/tasks/{id}', function (ServerRequest $request) use ($controller) : Response
{
    $result = $controller->show($request);
    $response = new Response();
    $response->getBody()->write($result); 

    return $response;
});

$map->get('show.all', '/tasks', function () use ($controller) : Response
{
    $result = $controller->showAll();
    $response = new Response();
    $response->getBody()->write($result); 

    return $response;
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