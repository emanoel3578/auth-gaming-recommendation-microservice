<?php

namespace App\Bootstrap;

use App\Bootstrap\ClassResolver;
use App\Bootstrap\Interfaces\IRouterResolver;
use Exception;
use FastRoute\Dispatcher;

class RouterResolver implements IRouterResolver
{
  public const ROUTE_NOT_FOUND = Dispatcher::NOT_FOUND;
  public const METHOD_NOT_ALLOWED = Dispatcher::METHOD_NOT_ALLOWED;
  public const ROUTE_FOUND = Dispatcher::FOUND;

  public final const ROUTE_RESOLUTION_INDEX = 0;
  public final const HANDLER_INDEX = 1;
  public final const PARAMETERS_INDEX = 2;

  private ClassResolver $classResolver;

  public function __construct(ClassResolver $classResolver)
  {
    $this->classResolver = $classResolver;
  }

  public function resolveRoute(array $routeInfo): mixed
  {
    switch ($routeInfo[self::ROUTE_RESOLUTION_INDEX]) {
      case self::ROUTE_NOT_FOUND:
        throw new Exception('Route not found', 404);
        break;
      case self::METHOD_NOT_ALLOWED:
        throw new Exception("Route verb not allowed", 402);
        break;
      case self::ROUTE_FOUND:
        return $this->classResolver->resolveClassName(
          $routeInfo[self::HANDLER_INDEX],
          $routeInfo[self::PARAMETERS_INDEX]
        );
        break;
      default:
        throw new Exception('Route not found', 404);
        break;
    }
  }
}