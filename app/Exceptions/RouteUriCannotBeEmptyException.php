<?php

namespace App\Exceptions;

use Exception;

class RouteUriCannotBeEmptyException extends Exception
{
  protected $message = 'The declared uri cannot be empty';
  protected $code = 402;
}