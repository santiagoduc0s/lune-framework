<?php

namespace Lune\Routing;

use Closure;
use Lune\Http\HttpMethod;
use Lune\Http\HttpNotFoundException;
use Lune\Http\Request;
use Lune\Http\Response;

class Router {
    /** @var Route[] */
    protected array $routes = [];

    public function __construct() {
        foreach (HttpMethod::cases() as $method) {
            $this->routes[$method->value] = [];
        }
    }

    /**
     * Search the Route where matches with the URI
     * @param Request $request
     * @throws HttpNotFoundException 
     * @return Route
     */
    public function resolveRoute(Request $request): Route {
        foreach ($this->routes[$request->method()->value] as $route) {
            if ($route->matches($request->uri())) {
                return $route;
            }
        }
        throw new HttpNotFoundException();
    }

    /**
     * Return the action for a request 
     * @param Request $request
     * @return Response
     */
    public function resolve(Request $request): Response {
        $route = $this->resolveRoute($request);
        $request->setRoute($route);
        $action = $route->action();

        if ($route->hasMiddleware()) {
            return $this->runMiddlewares($request, $route->middlewares(), $action);
        }

        return $action($request);
    }

    /**
     * Run all middlewares for a request
     */
    protected function runMiddlewares(Request $request, array $middlewares, Closure $target): Response {
        if (count($middlewares) == 0) {
            return $target($request);
        }

        return $middlewares[0]->handle(
            $request,
            fn ($request) => $this->runMiddlewares($request, array_slice($middlewares, 1), $target)
        );
    }

    protected function registerRoute(HttpMethod $method, string $uri, Closure $action): Route {
        $route = new Route($uri, $action);
        $this->routes[$method->value][] = $route;
        return $route;
    }

    public function get(string $uri, Closure $action): Route {
        return $this->registerRoute(HttpMethod::GET, $uri, $action);
    }

    public function post(string $uri, Closure $action): Route {
        return $this->registerRoute(HttpMethod::POST, $uri, $action);
    }

    public function put(string $uri, Closure $action): Route {
        return $this->registerRoute(HttpMethod::PUT, $uri, $action);
    }

    public function delete(string $uri, Closure $action): Route {
        return $this->registerRoute(HttpMethod::DELETE, $uri, $action);
    }
}
