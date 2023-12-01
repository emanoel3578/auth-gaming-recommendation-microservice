<?php

namespace App\Validator\RouterValidators;

use App\Exceptions\RouteUriCannotBeEmptyException;
use App\Exceptions\RouteUriHasInvalidCharacters;
use App\Exceptions\RouteUriIsHasInvalidTypeException;
use App\Validator\Interfaces\IRouterUriValidator;

class RouteUriValidator implements IRouterUriValidator
{
  private const MATCHES_EVERY_SPECIAL_CHARACTER_BUT_FOWARD_SLASH = "/[!@°²?₢ª#$%^&*()_+\-=\[\]{};':\"\\\\|,.<>?]/";
  
  public function validate(mixed $uri): bool
  {
    if (empty($uri)) {
      throw new RouteUriCannotBeEmptyException();
    }

    if (!is_string($uri) || empty(trim($uri))) {
      throw new RouteUriIsHasInvalidTypeException();
    }

    if (preg_match(self::MATCHES_EVERY_SPECIAL_CHARACTER_BUT_FOWARD_SLASH, $uri)) {
      throw new RouteUriHasInvalidCharacters();
    }

    return true;
  }
}