<?php

namespace App\Bootstrap;

use App\Services\Interfaces\IHandlerExtractorService;

class ClassResolver
{
  protected IHandlerExtractorService $handlerExtractorService;
  
  public function __construct(IHandlerExtractorService $handlerExtractorService)
  {
    $this->handlerExtractorService = $handlerExtractorService;
  }

  public function resolveClassName(string $handler, array $parameters): mixed
  {
    $handlerData = $this->handlerExtractorService->extractHandlerData($handler);
    $className = $handlerData['className'];

    if (!empty($handlerData['method'])) {
      return (new $className)->$handlerData['method']($parameters);
    }

    return new $className($parameters);
  }
}