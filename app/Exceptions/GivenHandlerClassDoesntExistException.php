<?php

namespace App\Exceptions;

use Exception;

class GivenHandlerClassDoesntExistException extends Exception
{
  protected $message = 'The handler class was not found in controllers namespace';
  protected $code = 404;
}