<?php

namespace App\Validator\RouterValidators;

use App\Bootstrap\ClassResolver;
use App\Exceptions\GivenHandlerClassDoesntExistException;
use App\Exceptions\GivenMethodNotFoundInHandlerClassException;
use App\Exceptions\RouteHandlerIsNotAValidClass;
use App\Validator\Interfaces\IRouterHandlerValidator;

class RouteClassHandlerValidator implements IRouterHandlerValidator
{
  public function validate(mixed $handler): bool
  {
    if (empty($handler)) {
      throw new GivenHandlerClassDoesntExistException();
    }

    if (!is_array($handler) || (!is_string($handler[ClassResolver::CLASS_NAME_INDEX]) || empty($handler[ClassResolver::CLASS_NAME_INDEX]))) {
      throw new RouteHandlerIsNotAValidClass();
    }

    if (!class_exists($handler[ClassResolver::CLASS_NAME_INDEX])) {
      throw new GivenHandlerClassDoesntExistException();
    }

    if (
      !empty($handler[ClassResolver::METHOD_NAME_INDEX]) &&
      !method_exists($handler[ClassResolver::CLASS_NAME_INDEX], $handler[ClassResolver::METHOD_NAME_INDEX])) {
      throw new GivenMethodNotFoundInHandlerClassException();
    }

    return true;
  }
}