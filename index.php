<?php

require 'Router.php';

$router = new Router;

$router->get('/', function () {
    print('soy la primera ruta');
});


try {
    $action = $router->resolve();
    $action();
} catch (Exception $e) {
    print('404 - Not Found');
    http_response_code(404);
}