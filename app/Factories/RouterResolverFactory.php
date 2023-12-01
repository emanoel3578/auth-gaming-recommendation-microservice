<?php

namespace App\Factories;

use App\Bootstrap\ClassResolver;
use App\Bootstrap\RouterResolver;
use App\Factories\Interfaces\IFactory;
use App\Services\Route\HandlerExtractorService;

class RouterResolverFactory implements IFactory
{
  public static function make($data = []): mixed
  {
    $handlerExtractorService = new HandlerExtractorService;
    $classResolver = new ClassResolver($handlerExtractorService);
    return new RouterResolver($classResolver);
  }
}