<?php

namespace App\Bootstrap;

use App\Services\Interfaces\IHandlerExtractorService;

class ClassResolver
{
  protected IHandlerExtractorService $handlerExtractorService;
  public const CLASS_NAME_INDEX = 0;
  public const METHOD_NAME_INDEX = 1;


  public function resolveClassName(string $handler, array $parameters): mixed
  {
    $handlerArr = explode('@', $handler);

    if (!empty($handlerArr[self::METHOD_NAME_INDEX])) {
      return (new $handlerArr[self::CLASS_NAME_INDEX])->{$handlerArr[self::METHOD_NAME_INDEX]}($parameters);
    }

    return new $handlerArr[self::CLASS_NAME_INDEX]($parameters);
  }
}