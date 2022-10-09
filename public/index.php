<?php

require_once '../vendor/autoload.php';

use Lune\Http\Middleware;
use Lune\Http\Request;
use Lune\Http\Response;
use Lune\Kernel;

$kernel = Kernel::bootstrap();

$kernel->router->get('/', function (Request $request): Response {
    return Response::json(['message' => 'soy la primera ruta']);
});

class AuthMiddleware implements Middleware {
    public function handle(Request $request, Closure $next): Response {
        if ($request->headers('Authorization') != 'test') {
            return Response::json(['message' => 'Not Authorization'])->setStatus(401);
        }
        return $next($request);
    }
}

$kernel->router->get('/middleware', fn (Request $request) => Response::json(['message' => 'middleware']))
    ->setMiddlewares([AuthMiddleware::class]);

$kernel->router->get('/params/{first}', function (Request $request): Response {
    return Response::json($request->routeParameters());
});

$kernel->router->post('/', function (Request $request): Response {
    return Response::json([...$request->data(), ...$request->query(),]);
});

$kernel->router->put('/put', function (Request $request): Response {
    return Response::json(['message' => 'method PUT']);
});

$kernel->router->get('/redirect', function (Request $request): Response {
    return Response::redirect('/');
});

// $kernel->router->get('/html', function (Request $request): Response {
//     return Response::text('soy un texto plano');
// });

$kernel->router->get('/html', function (Request $request): Response {
    return Response::view('home', ['test' => 'soy un parametro'], 'test');
});

$kernel->run();
