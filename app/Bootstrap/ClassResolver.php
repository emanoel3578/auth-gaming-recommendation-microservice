<?php

namespace App\Bootstrap;

class ClassResolver
{
  protected const CLASS_NAME_INDEX = 0;
  protected const HANDLER_METHOD_INDEX = 1;
  public final const CONTROLLERS_NAMESPACE = 'App\Controllers\\';

  public function __construct(string $className, array $parameters)
  {
    return $this->resolveClassName($className, $parameters);
  }

  public function resolveClassName(string $handler, array $parameters): mixed
  {
    if (str_contains($handler, '@')) {
      $classNameAndMethod = explode('@', $handler);
      $className = self::CONTROLLERS_NAMESPACE . $classNameAndMethod[self::CLASS_NAME_INDEX];
      $handlerMethod = $classNameAndMethod[self::HANDLER_METHOD_INDEX];

      return (new $className)->$handlerMethod($parameters);
    }

    $className = self::CONTROLLERS_NAMESPACE . $handler;
    return new $className($parameters);
  }
}