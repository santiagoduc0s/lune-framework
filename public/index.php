<?php

require_once '../vendor/autoload.php';

use Lune\HttpNotFoundException;
use Lune\Router;

$router = new Router();

$router->get('/', function () {
    print('soy la primera ruta');
});

$router->put('/', function () {
    print('PUT JE');
});


try {
    $action = $router->resolve($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);
    $action();
} catch (HttpNotFoundException $e) {
    print('404 - Not Found');
    http_response_code(404);
}
