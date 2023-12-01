<?php

namespace App\Exceptions;

use Exception;

class RouteMissingDeclaredInformationException extends Exception
{
  protected $message = 'The declared route is missing information';
  protected $code = 402;
}