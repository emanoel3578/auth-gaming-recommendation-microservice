<?php

namespace App\Adapters;

use App\Adapters\Interfaces\IRouterAdapter;
use App\Formatters\Interfaces\IFormatter;
use FastRoute\Dispatcher;
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

    return $this->dispatchToRoute($dispatcher);
  }

  private function dispatchToRoute(Dispatcher $dispatcher): array
  {
    $requestData = $this->mountRequestInfo();
    $dispatcherRouteInfo = $dispatcher->dispatch($requestData['method'], $requestData['uri']);
    return array_merge($dispatcherRouteInfo, [$requestData['params']]);
  }

  private function mountRequestInfo(): array
  {
    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];
    $params = '';

    if (false !== $pos = strpos($uri, '?')) {
      $params = substr($uri, $pos, strlen($uri) - 1);
      $uri = substr($uri, 0, $pos);
    }
    $uri = rawurldecode($uri);

    return [
      'method' => $httpMethod,
      'uri' => $uri,
      'params' => $params
    ];
  }
}