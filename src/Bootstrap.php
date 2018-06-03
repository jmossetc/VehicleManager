<?php declare(strict_types=1);

namespace ClickAndBoat;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$environment = 'development';

/**
 * Register the error handler
 */
$whoops = new \Whoops\Run;
if ($environment !== 'production') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else {
    $whoops->pushHandler(function ($e) {
        echo 'Todo: Friendly error page and send an email to the developer';
    });
}
$whoops->register();

$request = Request::createFromGlobals();

$routeDefinitionCallback = function (\FastRoute\RouteCollector $r) {
    $routes = Routes::getRoutes();
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
};


$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);



$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getRequestUri());

switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        $response = new Response(
            '404 - Page Not Found',
            Response::HTTP_NOT_FOUND,
            array('content-type' => 'text/plain')
        );
        $response->send();
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response = new Response(
            '405 - Method Not Allowed',
            Response::HTTP_METHOD_NOT_ALLOWED,
            array('content-type' => 'text/plain')
        );
        $response->send();
        break;
    case \FastRoute\Dispatcher::FOUND:
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];

        $injector = Dependencies::getControllerDependencies();

        $injector->make('Symfony\Component\HttpFoundation\Request');
        $injector->make('Symfony\Component\HttpFoundation\Response');

        $injector->make('Twig_Environment');

        $class = $injector->make($className);
        $class->$method($vars);
        break;
}
