<?php

namespace Lune\Http;

use Lune\Routing\Route;

class Request {
    /**
     * Route mached by URI
     *
     * @var Route
     */
    protected Route $route;

    protected string $uri;

    protected HttpMethod $method;

    protected array $data;

    protected array $query;

    public function setPostData(array $data): self {
        $this->data = $data;
        return $this;
    }

    public function setQueryParameters(array $query): self {
        $this->query = $query;
        return $this;
    }

    public function routeParameters(): array {
        return $this->route->parseParameters($this->uri);
    }

    /**
     * Get route mached by URI
     *
     * @return  Route
     */
    public function route() {
        return $this->route;
    }

    public function setRoute(Route $route): self {
        $this->route = $route;
        return $this;
    }


    public function uri() {
        return $this->uri;
    }

    public function setUri($uri): self {
        $this->uri = $uri;
        return $this;
    }

    public function method() {
        return $this->method;
    }

    public function setMethod($method): self {
        $this->method = $method;
        return $this;
    }

    public function data() {
        return $this->data;
    }

    public function query() {
        return $this->query;
    }
}
