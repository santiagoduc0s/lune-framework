<?php

namespace Lune\Server;

use Lune\Http\HttpMethod;
use Lune\Http\Request;
use Lune\Http\Response;

interface Server {
    /**
     * Get request by client
     *
     * @return Request
     */
    public function getRequest(): Request;
    public function sendResponse(Response $response);
}
