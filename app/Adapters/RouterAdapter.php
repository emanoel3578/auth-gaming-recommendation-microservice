<?php

namespace App\Adapters;

use App\Adapters\Interfaces\IRouterAdapter;
use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

class RouterAdapter implements IRouterAdapter
{
  public function createRoutes(array $routes): array
  {
    $dispatcher = simpleDispatcher(function(RouteCollector $r) use ($routes) {
      foreach ($routes as $route) {
        $r->addRoute($route['method'], $route['uri'], $route['handler']);
      }
    });

    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }
    $uri = rawurldecode($uri);

    return $dispatcher->dispatch($httpMethod, $uri);
  }
}