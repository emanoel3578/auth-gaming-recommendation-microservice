<?php

namespace App\Exceptions;

use Exception;

class RouteUriHasInvalidCharacters extends Exception
{
  protected $message = 'The declared uri has invalid characters';
  protected $code = 402;
}