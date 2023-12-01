<?php

namespace App\Exceptions;

use Exception;

class RouteHandlerIsNotAValidClass extends Exception
{
  protected $message = 'The declared route does not have a valid handler class';
  protected $code = 402;
}