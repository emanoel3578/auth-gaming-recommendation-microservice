<?php

namespace App\Exceptions;

use Exception;

class RouteVerbNotAllowed extends Exception
{
  public $message = '%s this verb is not allowed for this route';
  public $code = 403;
}