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

    /**
     * HTTP method for this request
     * @var HttpMethod
     */
    protected HttpMethod $method;

    /**
     * Headers from request
     * @var array<string, string>
     */
    protected array $headers = [];

    /**
     * Data from body of request 
     * @var array
     */
    protected array $data;

    /**
     * Data from query params
     * @var array
     */
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

    public function route(): Route {
        return $this->route;
    }

    public function setRoute(Route $route): self {
        $this->route = $route;
        return $this;
    }


    public function uri(): string {
        return $this->uri;
    }

    public function setUri($uri): self {
        $this->uri = $uri;
        return $this;
    }

    /**
     * Get HTTP method for this request
     * @return HttpMethod
     */
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

    /**
     * Return all headers or return a specific header
     * @param string|null $key
     * @return array|string|null
     */
    public function headers(string $key = null): array | string | null {
        if (is_null($key)) {
            return $this->headers;
        }
        return $this->headers[strtolower($key)] ?? null;
    }

    public function setHeaders(array $headers): self {
        foreach ($headers as $header => $value) {
            $this->headers[strtolower($header)] = $value;
        }
        return $this;
    }
}
