<?php

require_once '../vendor/autoload.php';

use Lune\HttpNotFoundException;
use Lune\PhpNativeServer;
use Lune\Request;
use Lune\Route;
use Lune\Router;
use Lune\Server;

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
