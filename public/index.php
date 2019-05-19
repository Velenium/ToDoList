<?php

use App\Options;
use Aura\Router\RouterContainer;
use Zend\Diactoros\ServerRequestFactory;

// set up composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// create a server request object
$request = ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

// create the router container and get the routing map
$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

// add a route to the map, and a handler for it
	
$map->post('set.task', '/add', function ($request) {
	$new_task = $request->getQueryParams()['task'];
    $table = new Options();
    $table->addNewTask($new_task);
    $response = new Zend\Diactoros\Response();
    $response->getBody()->write("New one added!");
    return $response;
});

$map->put('complete.task', '/complete/{id}', function ($request) {
    $task_id = $request->getAttribute('id');
    $table = new Options();
    $table->makeTaskComplieted($task_id);
    $response = new Zend\Diactoros\Response();
    $response->getBody()->write("Completed!");
    return $response;
});

$map->delete('delete.task', '/delete/{id}', function ($request) {
    $task_id = $request->getAttribute('id');
    $table = new Options();
    $table->deleteTask($task_id);
    $response = new Zend\Diactoros\Response();
    $response->getBody()->write("Deleted!");
    return $response;
});

$map->get('show.all', '/show', function () {
    $table = new Options();
	$table->showAll();
	$response = new Zend\Diactoros\Response();
    $response->getBody()->write("All the things you need to do!");
    return $response;
});

// get the route matcher from the container ...
$matcher = $routerContainer->getMatcher();

// .. and try to match the request to a route.
$route = $matcher->match($request);
if (! $route) {
    echo "No route found for the request.";
    exit;
}

// add route attributes to the request
foreach ($route->attributes as $key => $val) {
    $request = $request->withAttribute($key, $val);
}

// dispatch the request to the route handler.
// (consider using https://github.com/auraphp/Aura.Dispatcher
// in place of the one callable below.)
$callable = $route->handler;
$response = $callable($request);

// emit the response
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}
http_response_code($response->getStatusCode());
echo $response->getBody();