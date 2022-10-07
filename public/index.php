<?php

require_once '../vendor/autoload.php';

use Lune\Http\Request;
use Lune\Http\Response;
use Lune\Kernel;

$kernel = Kernel::bootstrap();

$kernel->router->get('/', function (Request $request): Response {
    return Response::json(['message' => 'soy la primera ruta']);
});

$kernel->router->get('/params/{first}', function (Request $request): Response {
    return Response::json($request->routeParameters());
});

$kernel->router->post('/', function (Request $request): Response {
    return Response::json([...$request->data(), ...$request->query(),]);
});

$kernel->router->put('/put', function (Request $request): Response {
    return Response::json(['message' => 'method PUT']);
});

$kernel->router->get('/redirect', function (Request $request): Response {
    return Response::redirect('/');
});

$kernel->run();
