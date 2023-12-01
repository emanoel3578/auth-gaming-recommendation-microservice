<?php

namespace App\Exceptions;

use Exception;

class RouteHasEmptyHandlerException extends Exception
{
  protected $message = 'The declared route cannot have a empty handler';
  protected $code = 402;
}