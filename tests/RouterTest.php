<?php

namespace Lune\Tests;

use Lune\HttpMethods;
use Lune\Route;
use Lune\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function test_resolve_basic_route_with_callback_action()
    {
        $uri = '/test';
        $action = fn () => 'test';
        $router = new Router();
        $router->get($uri, $action);

        $route = $router->resolve(
            method: HttpMethods::GET->value,
            uri: $uri
        );

        $this->assertEquals($action, $route->action());
    }

    public function test_resolve_multiple_basic_route_with_callback_action()
    {
        $routes = [
            '/test' => fn () => 'test',
            '/foo' => fn () => 'foo',
            '/bar' => fn () => 'bar',
            '/long/nested/route' => fn () => 'long nested route',
        ];

        $router = new Router();

        foreach ($routes as $uri => $action) {
            $router->get($uri, $action);
        }

        foreach ($routes as $uri => $action) {
            $route = $router->resolve(
                method: HttpMethods::GET->value,
                uri: $uri
            );
            $this->assertEquals($action, $route->action());
        }
    }

    public function test_resolve_multiple_basic_route_with_callback_action_for_different_http_methods()
    {
        $routes = [
            [HttpMethods::GET, '/test', fn () => 'GET'],
            [HttpMethods::POST, '/test', fn () => 'POST'],
            [HttpMethods::PUT, '/test', fn () => 'PUT'],
            [HttpMethods::DELETE, '/test', fn () => 'DELETE'],
        ];

        $router = new Router();

        foreach ($routes as [$method, $uri, $action]) {
            match ($method) {
                HttpMethods::GET => $router->get($uri, $action),
                HttpMethods::POST => $router->post($uri, $action),
                HttpMethods::PUT => $router->put($uri, $action),
                HttpMethods::DELETE => $router->delete($uri, $action),
            };
        }

        foreach ($routes as [$method, $uri, $action]) {
            $route = $router->resolve(
                method: $method->value,
                uri: $uri
            );
            $this->assertEquals($action, $route->action());
        }
    }
}
