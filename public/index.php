<?php

require_once '../vendor/autoload.php';

use Lune\Http\HttpNotFoundException;
use Lune\Http\Request;
use Lune\Http\Response;
use Lune\Routing\Router;
use Lune\Server\PhpNativeServer;

$router = new Router();

$router->get('/', function (Request $request) {
    return Response::json(['message' => 'soy la primera ruta']);
});

$router->put('/put', function (Request $request) {
    print('method PUT');
});

$router->get('/redirect', function (Request $request) {
    return Response::redirect('/');
});


try {
    $server = new PhpNativeServer();
    $request = new Request($server);
    $route = $router->resolve($request);
    $action = $route->action();
    $response = $action($request);
    $server->sendResponse($response);
} catch (HttpNotFoundException $e) {
    
    $server->sendResponse(Response::text('Not Found', 404));
}
