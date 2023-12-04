<?php

namespace App\Bootstrap;

use App\Bootstrap\Interfaces\IRouterResolver;
use App\Bootstrap\Router\ClassResolver;
use App\Exceptions\RouteNotFoundException;
use App\Exceptions\RouteVerbNotAllowed;
use App\Formatters\Router\RouteDispatchedInfoFormatter;
use FastRoute\Dispatcher;

class RouterResolver implements IRouterResolver
{
  public const ROUTE_NOT_FOUND = Dispatcher::NOT_FOUND;
  public const METHOD_NOT_ALLOWED = Dispatcher::METHOD_NOT_ALLOWED;
  public const ROUTE_FOUND = Dispatcher::FOUND;

  public final const ROUTE_RESOLUTION_INDEX = 0;
  public final const HANDLER_INDEX = 1;
  public final const METHOD_HANDLER_INDEX = 1;
  public final const PARAMETERS_INDEX = 3;

  private ClassResolver $classResolver;

  public function __construct(ClassResolver $classResolver)
  {
    $this->classResolver = $classResolver;
  }

  public function resolveRoute(array $routeInfo): mixed
  {
    if (empty($routeInfo)) {
      throw new RouteNotFoundException();
    }

    switch ($routeInfo[RouteDispatchedInfoFormatter::STATUS_INDEX_FORMATTED]) {
      case self::ROUTE_NOT_FOUND:
        throw new RouteNotFoundException();
        break;
      case self::METHOD_NOT_ALLOWED:
        throw new RouteVerbNotAllowed();
        break;
      case self::ROUTE_FOUND:
        return $this->classResolver->resolveClassName(
          $routeInfo[RouteDispatchedInfoFormatter::CLASS_NAME_HANDLER_INDEX_FORMATTED],
          $routeInfo[RouteDispatchedInfoFormatter::METHOD_HANDLER_INDEX_FORMATTED],
          $routeInfo[RouteDispatchedInfoFormatter::PARAMETERS_INDEX_FORMATTED]
        );
        break;
      default:
        throw new RouteNotFoundException();
        break;
    }
  }
}