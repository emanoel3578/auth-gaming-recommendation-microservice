<?php

namespace App\Bootstrap\Router;

use App\Services\Interfaces\IHandlerExtractorService;

class ClassResolver
{
  protected IHandlerExtractorService $handlerExtractorService;

  public function resolveClassName(string $handler, string $methodHandler = '', ?array $parameters = null): mixed
  {
    if (!empty($methodHandler)) {
      return (new $handler)->{$methodHandler}($parameters);
    }

    return new $handler($parameters);
  }
}