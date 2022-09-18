<?php

require_once '../vendor/autoload.php';

use Lune\HttpNotFoundException;
use Lune\Router;

$router = new Router();

$router->get('/', function () {
    print('soy la primera ruta');
});


try {
    $action = $router->resolve();
    $action();
} catch (HttpNotFoundException $e) {
    print('404 - Not Found');
    http_response_code(404);
}