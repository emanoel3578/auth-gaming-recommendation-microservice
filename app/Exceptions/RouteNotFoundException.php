<?php

namespace App\Exceptions;

use Exception;

class RouteNotFoundException extends Exception
{
  public $message = 'Route not found';
  public $code = 404;
}