<?php

namespace App\Bootstrap\AppFactory;

use App\Adapters\Interfaces\IRouterAdapter;
use App\Bootstrap\ClassResolver;
use App\Routes\Api\Routes;
use App\Validator\Interfaces\IRouterValidator;
use Exception;
use FastRoute\Dispatcher;

class Router
{
  public final const ROUTE_RESOLUTION_INDEX = 0;
  public final const HANDLER_INDEX = 1;
  public final const PARAMETERS_INDEX = 2;

  protected IRouterAdapter $routerAdapter;
  protected Routes $routes;
  protected IRouterValidator $routerValidator;

  public function __construct(IRouterAdapter $routerAdapter, Routes $routes, IRouterValidator $routerValidator)
  {
    $this->routerAdapter = $routerAdapter;
    $this->routes = $routes;
    $this->routerValidator = $routerValidator;
  }

  public function createAppRoutes(): array
  {
    return $this->routerAdapter->createRoutes($this->getAppRoutes());
  }

  public function getAppRoutes(): array
  {
    $routes = $this->routes->getRoutes();
    $this->routerValidator->validateDeclaredRoutes($routes);
    return $routes;
  }

  public function resolveRoute(array $routeInfo): mixed
  {
    switch ($routeInfo[self::ROUTE_RESOLUTION_INDEX]) {
      case Dispatcher::NOT_FOUND:
        throw new Exception('Route not found', 404);
        break;
      case Dispatcher::METHOD_NOT_ALLOWED:
        throw new Exception("Route verb not allowed", 402);
        break;
      case Dispatcher::FOUND:
        return new ClassResolver($routeInfo[self::HANDLER_INDEX], $routeInfo[self::PARAMETERS_INDEX]);
        break;
    }
  }
}