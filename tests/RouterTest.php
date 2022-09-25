<?php

namespace Lune\Tests;

use Lune\HttpMethod;
use Lune\Request;
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

        $route = $router->resolve(new Request(new MockServer($uri, HttpMethod::GET)));

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
            $route = $router->resolve(new Request(new MockServer($uri, HttpMethod::GET)));
            $this->assertEquals($action, $route->action());
        }
    }

    public function test_resolve_multiple_basic_route_with_callback_action_for_different_http_methods()
    {
        $routes = [
            [HttpMethod::GET, '/test', fn () => 'GET'],
            [HttpMethod::POST, '/test', fn () => 'POST'],
            [HttpMethod::PUT, '/test', fn () => 'PUT'],
            [HttpMethod::DELETE, '/test', fn () => 'DELETE'],
        ];

        $router = new Router();

        foreach ($routes as [$method, $uri, $action]) {
            match ($method) {
                HttpMethod::GET => $router->get($uri, $action),
                HttpMethod::POST => $router->post($uri, $action),
                HttpMethod::PUT => $router->put($uri, $action),
                HttpMethod::DELETE => $router->delete($uri, $action),
            };
        }

        foreach ($routes as [$method, $uri, $action]) {
            $route = $router->resolve(new Request(new MockServer($uri, HttpMethod::GET)));
            $this->assertEquals($action, $route->action());
        }
    }
}
