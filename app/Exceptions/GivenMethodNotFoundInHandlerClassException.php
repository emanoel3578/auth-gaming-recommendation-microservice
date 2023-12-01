<?php

namespace App\Exceptions;

use Exception;

class GivenMethodNotFoundInHandlerClassException extends Exception
{
  protected $message = 'The given method was not found in the handler class';
  protected $code = 404;
}