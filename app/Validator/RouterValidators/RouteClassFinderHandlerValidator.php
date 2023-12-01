<?php

namespace App\Validator\RouterValidators;

use App\Exceptions\GivenHandlerClassDoesntExistException;
use App\Exceptions\GivenMethodNotFoundInHandlerClassException;
use App\Services\Interfaces\IClassLookerService;
use App\Services\Interfaces\IHandlerExtractorService;
use App\Validator\Interfaces\IRouterHandlerValidator;

class RouteClassFinderHandlerValidator implements IRouterHandlerValidator
{
  protected IHandlerExtractorService $handlerExtractorService;
  protected IClassLookerService $classLookerService;
  public final const CONTROLLERS_NAMESPACE = 'app/Controllers';
  
  public function __construct(
    IHandlerExtractorService $handlerExtractorService,
    IClassLookerService $classLookerService
    )
  {
    $this->handlerExtractorService = $handlerExtractorService;
    $this->classLookerService = $classLookerService;
  }

  public function validate(mixed $handler): bool
  {
    $handlerData = $this->handlerExtractorService->extractHandlerData($handler);

    if (!$this->classLookerService->findClassByFileName($handlerData['className'], self::CONTROLLERS_NAMESPACE)) {
      throw new GivenHandlerClassDoesntExistException();
    }

    if (
      !empty($handlerData['method']) &&
      !$this->classLookerService->findMethodInClassByContents($handlerData['className'], $handlerData['method'])
      ) {
      throw new GivenMethodNotFoundInHandlerClassException();
    }

    return true;
  }
}