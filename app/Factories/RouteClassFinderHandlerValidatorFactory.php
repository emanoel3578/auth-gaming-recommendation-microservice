<?php

namespace App\Factories;

use App\Adapters\FileManagerAdapter;
use App\Factories\Interfaces\IRouteClassFinderHandlerValidatorFactory;
use App\Services\Files\FileFinder;
use App\Services\Files\MethodFinder;
use App\Services\Route\ClassLookerService;
use App\Services\Route\HandlerExtractorService;
use App\Validator\RouterValidators\RouteClassFinderHandlerValidator;
use Symfony\Component\Finder\Finder;

class RouteClassFinderHandlerValidatorFactory implements IRouteClassFinderHandlerValidatorFactory
{
  public static function make(): RouteClassFinderHandlerValidator
  {
    $fileFinder = new Finder();
    $fileManagerAdapter = new FileManagerAdapter($fileFinder);
    $fileFinder = new FileFinder($fileManagerAdapter);
    $methodFinder = new MethodFinder($fileManagerAdapter);
    $classLookerService = new ClassLookerService($fileFinder, $methodFinder);
    $handlerExtactor = new HandlerExtractorService();
    return new RouteClassFinderHandlerValidator($handlerExtactor, $classLookerService);
  }
}