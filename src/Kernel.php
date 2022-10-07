<?php

namespace Lune;

use Lune\Container\Container;
use Lune\Http\HttpNotFoundException;
use Lune\Http\Request;
use Lune\Http\Response;
use Lune\Routing\Router;
use Lune\Server\PhpNativeServer;
use Lune\Server\Server;

class Kernel {
    public Router $router;

    public Request $request;

    public Server $server;

    public static function bootstrap(): Kernel {
        $kernel = Container::singleton(self::class);
        $kernel->router = new Router();
        $kernel->server = new PhpNativeServer();
        $kernel->request = $kernel->server->getRequest();
        return $kernel;
    }

    public function run(): void {
        try {
            $route = $this->router->resolve($this->request);
            $this->request->setRoute($route);
            $action = $route->action();
            $response = $action($this->request);
            $this->server->sendResponse($response);
        } catch (HttpNotFoundException $e) {
            $this->server->sendResponse(Response::text('Not Found', 404));
        }
    }
}
