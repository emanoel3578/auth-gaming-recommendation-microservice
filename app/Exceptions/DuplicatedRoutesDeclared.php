<?php

namespace App\Exceptions;

use Exception;

class DuplicatedRoutesDeclared extends Exception
{
  public $message = 'No duplicated routes are allowed';
  public $code = 402;
}