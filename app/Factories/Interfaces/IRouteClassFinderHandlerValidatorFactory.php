<?php

namespace App\Factories\Interfaces;

use App\Validator\RouterValidators\RouteClassFinderHandlerValidator;

interface IRouteClassFinderHandlerValidatorFactory
{
  public static function make(): RouteClassFinderHandlerValidator;
}