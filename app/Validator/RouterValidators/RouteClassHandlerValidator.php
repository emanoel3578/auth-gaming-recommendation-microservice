<?php

namespace App\Validator\RouterValidators;

use App\Exceptions\GivenHandlerClassDoesntExistException;
use App\Exceptions\GivenMethodNotFoundInHandlerClassException;
use App\Exceptions\RouteHandlerIsNotAValidClass;
use App\Validator\Interfaces\IRouterHandlerValidator;

class RouteClassHandlerValidator implements IRouterHandlerValidator
{
  public const CLASS_NAME_INDEX = 0;
  public const METHOD_NAME_INDEX = 1;

  public function validate(mixed $handler): bool
  {
    if (empty($handler)) {
      throw new GivenHandlerClassDoesntExistException();
    }

    if (
      !is_array($handler) ||
      (!is_string($handler[self::CLASS_NAME_INDEX]) ||
      empty($handler[self::CLASS_NAME_INDEX]))
      ) {
      throw new RouteHandlerIsNotAValidClass();
    }

    if (!class_exists($handler[self::CLASS_NAME_INDEX])) {
      throw new GivenHandlerClassDoesntExistException();
    }

    if (
      !empty($handler[self::METHOD_NAME_INDEX]) &&
      !method_exists($handler[self::CLASS_NAME_INDEX], $handler[self::METHOD_NAME_INDEX])) {
      throw new GivenMethodNotFoundInHandlerClassException();
    }

    return true;
  }
}