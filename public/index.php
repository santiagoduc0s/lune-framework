<?php

require_once '../vendor/autoload.php';

use Lune\Http\HttpNotFoundException;
use Lune\Http\Request;
use Lune\Http\Response;
use Lune\Routing\Router;
use Lune\Server\PhpNativeServer;

$router = new Router();

$router->get('/', function (Request $request): Response {
    return Response::json(['message' => 'soy la primera ruta']);
});

$router->get('/params/{first}', function (Request $request): Response {
    return Response::json($request->routeParameters());
});

$router->post('/', function (Request $request): Response {
    return Response::json([...$request->data(), ...$request->query(),]);
});

$router->put('/put', function (Request $request): Response {
    return Response::json(['message' => 'method PUT']);
});

$router->get('/redirect', function (Request $request): Response {
    return Response::redirect('/');
});


try {
    $server = new PhpNativeServer();
    $request = $server->getRequest();
    $route = $router->resolve($request);
    $request->setRoute($route);
    $action = $route->action();
    $response = $action($request);
    $server->sendResponse($response);
} catch (HttpNotFoundException $e) {
    $server->sendResponse(Response::text('Not Found', 404));
}
