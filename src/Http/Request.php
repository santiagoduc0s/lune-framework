<?php

namespace Lune\Http;

use Lune\Server\Server;

class Request {
    protected $uri;

    protected HttpMethod $method;

    protected array $data;

    protected array $query;

    public function __construct(Server $server) {
        $this->uri = $server->requestUri();
        $this->method = $server->requestMethod();
        $this->data = $server->postData();
        $this->query = $server->queryParams();
    }

    public function uri() {
        return $this->uri;
    }

    public function method() {
        return $this->method;
    }

    /**
     * Get POST data
     *
     * @return array
     */
    public function data(): array {
        return $this->data;
    }

    /**
     * Get query params
     *
     * @return array
     */
    public function query(): array {
        return $this->query;
    }
}
