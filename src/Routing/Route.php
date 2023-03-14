<?php

namespace Lune\Routing;

use ArrayObject;
use Closure;
use Lune\Container\Container;
use Lune\Http\Middleware;
use Lune\Http\Request;
use Lune\Kernel;

class Route {
    protected string $uri;

    /**
     * Action when the route is resolve
     * @var Closure(Request $request): Response
     */
    protected Closure $action;

    protected string $regex;

    protected array $parameters;

    /** @var Middleware[] */
    protected array $middlewares = [];

    public function __construct(string $uri, Closure $action) {
        $this->uri = $uri;
        $this->action = $action;
        $this->regex = preg_replace('/\{([a-zA-Z]+)\}/', '([a-zA-Z0-9]+)', $uri);
        preg_match_all('/\{([a-zA-Z]+)\}/', $uri, $parameters);
        $this->parameters = $parameters[1];
    }

    public function matches(string $uri): bool {
        return preg_match("#^$this->regex/?$#", $uri);
    }

    public function hasParameters(): bool {
        return count($this->parameters);
    }

    public function parseParameters(string $uri): array {
        preg_match("#^$this->regex$#", $uri, $arguments);

        return array_combine($this->parameters, array_slice($arguments, 1));
    }

    public static function get(string $uri, Closure $action): self {
        /** @var Router $router */
        $router = Container::resolve(Kernel::class)->router;
        return $router->get($uri, $action);
    }

    // ------------------------------------------------- gets

    public function uri(): string {
        return $this->uri;
    }

    public function action(): Closure {
        return $this->action;
    }

    /** @return Middleware[] */
    public function middlewares() {
        return $this->middlewares;
    }

    // --------------------------------------------------

    /** @param string[] $middlewares Names of middlewares clases */
    public function setMiddlewares(array $middlewares): self {
        $this->middlewares = array_map(fn (string $middleware) => new $middleware(), $middlewares);
        return $this;
    }

    public function hasMiddleware(): bool {
        return count($this->middlewares) > 0;
    }
}
