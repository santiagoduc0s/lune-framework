<?php

require_once '../vendor/autoload.php';

use Lune\HttpNotFoundException;
use Lune\Route;
use Lune\Router;

$router = new Router();

$router->get('/', function () {
    print('soy la primera ruta');
});

$router->put('/put', function () {
    print('method PUT');
});


try {
    $route = $router->resolve($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);

    // var_dump($route);
    
    $action = $route->action();
    $action();
    
} catch (HttpNotFoundException $e) {
    print('404 - Not Found');
    http_response_code(404);
}
