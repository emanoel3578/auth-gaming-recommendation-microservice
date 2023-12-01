<?php

namespace App\Exceptions;

use Exception;

class NotAllowedMethodRouteException extends Exception
{
  protected $message = 'The declared method for the route %s is not valid';
  protected $code = 402;
}