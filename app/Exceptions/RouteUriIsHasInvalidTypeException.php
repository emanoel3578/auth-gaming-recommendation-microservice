<?php

namespace App\Exceptions;

use Exception;

class RouteUriIsHasInvalidTypeException extends Exception
{
  protected $message = 'The declared uri is not a valid type';
  protected $code = 402;
}