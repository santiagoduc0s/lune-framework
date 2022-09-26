<?php

require_once '../vendor/autoload.php';

use Lune\Http\HttpNotFoundException;
use Lune\Http\Request;
use Lune\Http\Response;
use Lune\Routing\Router;
use Lune\Server\PhpNativeServer;

$router = new Router();

$router->get('/', function (Request $request) {
    $response = new Response();
    $response->setHeader('Content-Type', 'application/json');
    $response->setContent(json_encode(['message' => 'soy la primera ruta']));
    return $response;
});

$router->put('/put', function (Request $request) {
    print('method PUT');
});


try {

    $server = new PhpNativeServer();
    $request = new Request($server);
    $route = $router->resolve($request);
    $action = $route->action();
    $response = $action($request);
    $server->sendResponse($response);
    
} catch (HttpNotFoundException $e) {
    $response = new Response();
    $response->setStatus(404);
    $response->setHeader('Content-Type', 'application/json');
    // $response->setContent(json_encode(['message' => '404 - Not Found']));
    $server->sendResponse($response);
}
