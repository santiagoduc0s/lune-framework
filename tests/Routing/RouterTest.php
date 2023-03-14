<?php

namespace Lune\Tests\Routing;

use Lune\Http\HttpMethod;
use Lune\Http\Middleware;
use Lune\Http\Request;
use Lune\Http\Response;
use Lune\Routing\Router;
use Lune\Server\Server;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {
    // private function createMockRequest(string $uri, HttpMethod $method): Request {
    //     $mockServer = $this->getMockBuilder(Server::class)->getMock();
    //     $mockServer->method('requestUri')->willReturn($uri);
    //     $mockServer->method('requestMethod')->willReturn($method);
    //     return new Request($mockServer);
    // }

    // public function test_resolve_basic_route_with_callback_action() {
    //     $uri = '/test';
    //     $action = fn () => 'test';
    //     $router = new Router();
    //     $router->get($uri, $action);

    //     $route = $router->resolve($this->createMockRequest($uri, HttpMethod::GET));

    //     $this->assertEquals($action, $route->action());
    // }

    // public function test_resolve_multiple_basic_route_with_callback_action() {
    //     $routes = [
    //         '/test' => fn () => 'test',
    //         '/foo' => fn () => 'foo',
    //         '/bar' => fn () => 'bar',
    //         '/long/nested/route' => fn () => 'long nested route',
    //     ];

    //     $router = new Router();

    //     foreach ($routes as $uri => $action) {
    //         $router->get($uri, $action);
    //     }

    //     foreach ($routes as $uri => $action) {
    //         $route = $router->resolve($this->createMockRequest($uri, HttpMethod::GET));
    //         $this->assertEquals($action, $route->action());
    //     }
    // }

    // public function test_resolve_multiple_basic_route_with_callback_action_for_different_http_methods() {
    //     $routes = [
    //         [HttpMethod::GET, '/test', fn () => 'GET'],
    //         [HttpMethod::POST, '/test', fn () => 'POST'],
    //         [HttpMethod::PUT, '/test', fn () => 'PUT'],
    //         [HttpMethod::DELETE, '/test', fn () => 'DELETE'],
    //     ];

    //     $router = new Router();

    //     foreach ($routes as [$method, $uri, $action]) {
    //         match ($method) {
    //             HttpMethod::GET => $router->get($uri, $action),
    //             HttpMethod::POST => $router->post($uri, $action),
    //             HttpMethod::PUT => $router->put($uri, $action),
    //             HttpMethod::DELETE => $router->delete($uri, $action),
    //         };
    //     }

    //     foreach ($routes as [$method, $uri, $action]) {
    //         $route = $router->resolve($this->createMockRequest($uri, $method));
    //         $this->assertEquals($action, $route->action());
    //     }
    // }

    private function createMockMiddleware(string $uri, HttpMethod $method): Request {
        $mockServer = $this->getMockBuilder(Middleware::class)->getMock();
        $mockServer->method('requestUri')->willReturn($uri);
        $mockServer->method('requestMethod')->willReturn($method);
        return new Request($mockServer);
    }

    public function test_run_middlewares() {

        // anonymous class
        $midd_1 = new class implements Middleware {
            public function handle(Request $request, \Closure $next): Response {
                if ($request->headers('Authorization') != 'test') {
                    return Response::json(['message' => 'Not Authorization'])->setStatus(401);
                }
                return $next($request);
            }
        };

        $router = new Router();
        $uri = '/test';
        $expectedResponse = Response::text('test');
        $action = fn(Request $request) => $expectedResponse;
        // $router->get($uri, )

    }
}
