<?php

require_once '../vendor/autoload.php';

use Lune\Http\HttpNotFoundException;
use Lune\Http\Request;
use Lune\Routing\Router;
use Lune\Server\PhpNativeServer;

$router = new Router();

$router->get('/', function () {
    print('soy la primera ruta');
});

$router->put('/put', function () {
    print('method PUT');
});


try {

    $request = new Request(new PhpNativeServer());

    $route = $router->resolve($request);
    
    $action = $route->action();
    $action();
    
} catch (HttpNotFoundException $e) {
    print('404 - Not Found');
    http_response_code(404);
}
