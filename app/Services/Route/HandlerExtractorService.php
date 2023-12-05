<?php

namespace App\Services\Route;

use App\Services\Interfaces\IHandlerExtractorService;

class HandlerExtractorService implements IHandlerExtractorService
{
  protected const CLASS_NAME_INDEX = 0;
  protected const HANDLER_METHOD_INDEX = 1;

  public function extractHandlerData(string $handler): array
  {
    if (str_contains($handler, '@')) {
      $classNameAndMethod = explode('@', $handler);
      $className = $classNameAndMethod[self::CLASS_NAME_INDEX];
      $handlerMethod = $classNameAndMethod[self::HANDLER_METHOD_INDEX];

      return [
        'className' => $className,
        'method' => $handlerMethod
      ];
    }

    return [
      'className' => $handler
    ];
  }
}