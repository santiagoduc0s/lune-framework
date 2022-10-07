<?php

namespace Lune\Tests\Http;

use Lune\Http\HttpMethod;
use Lune\Http\Request;
use Lune\Server\Server;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase {
    public function test_request_returns_data_obtained_from_server_correctly() {
        // Crea un objeto de tipo Lune\Http\Request. Utiliza los setters para
        // poner el valor de la URI, el metodo HTTP, los query parameters y
        // el POST data. Despues comprueba que que los getters devuelven
        // lo que has puesto.

        $uri = '/test/test';


        $mockServer = $this->getMockBuilder(Server::class)->getMock();
        $mockServer->method('requestUri')->willReturn($uri);
        $mockServer->method('requestMethod')->willReturn($method);
    }
}
