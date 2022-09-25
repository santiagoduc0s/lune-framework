<?php

namespace Lune\Tests;

use Lune\Routing\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function routesWithoutParameters()
    {
        return [
            ['/'],
            ['/test'],
            ['/test/nested'],
            ['/test/another/nested'],
            ['/test/another/nested/test'],
        ];
    }

    /**
     * @dataProvider routesWithoutParameters
     */
    public function test_regex_without_parameters(string $uri)
    {
        $route = new Route($uri, fn () => 'test');
        $this->assertTrue($route->matches($uri));
        $this->assertFalse($route->matches("$uri/fail"));
        $this->assertFalse($route->matches("/fail/$uri"));
        $this->assertFalse($route->matches("/fail/$uri/other"));
        $this->assertFalse($route->matches("/fail"));
    }

    public function routesWithParameters()
    {
        return [
            [
                '/test/{test}',
                '/test/12345',
                [
                    'test' => '12345',
                ]
            ],
            [
                '/test/{test}/nested',
                '/test/12345/nested',
                [
                    'test' => '12345',
                ]
            ],
            [
                '/{test}',
                '/12345',
                [
                    'test' => '12345',
                ]
            ],
            [
                '/{test}/test',
                '/12345/test',
                [
                    'test' => '12345',
                ]
            ],
            [
                '/{test}/test/{name}/nested/foo/{loop}',
                '/12345/test/santi/nested/foo/23',
                [
                    'test' => '12345',
                    'name' => 'santi',
                    'loop' => '23',
                ]
            ],
        ];
    }

    /**
     * @dataProvider routesWithParameters
     */
    public function test_regex_with_parameters(string $definitioUri, string $requestedUri)
    {
        $route = new Route($definitioUri, fn () => 'test');
        $this->assertTrue($route->matches($requestedUri));
        $this->assertFalse($route->matches("$requestedUri/fail"));
        $this->assertFalse($route->matches("/fail/$requestedUri"));
        $this->assertFalse($route->matches("/fail/$requestedUri/other"));
    }

    /**
     * @dataProvider routesWithParameters
     */
    public function test_parse_parameters(string $definitioUri, string $requestedUri, array $expectedParameters)
    {
        $route = new Route($definitioUri, fn () => 'test');
        $this->assertTrue($route->hasParameters());
        $this->assertEquals($expectedParameters, $route->parseParameters($requestedUri));
    }
}
