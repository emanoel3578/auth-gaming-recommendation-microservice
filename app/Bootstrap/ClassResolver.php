<?php

namespace App\Bootstrap;

class ClassResolver
{
  public final const CONTROLLERS_NAMESPACE = 'App\Controllers\\';

  public function __construct(string $className, array $parameters)
  {
    return $this->resolveClassName($className, $parameters);
  }

  public function resolveClassName(string $className, array $parameters): mixed
  {
    $className = self::CONTROLLERS_NAMESPACE . $className;
    return new $className($parameters);
  }
}