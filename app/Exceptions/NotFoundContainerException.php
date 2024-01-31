<?php

namespace App\Exceptions;

use App\Container\Interfaces\INotFoundException;
use Exception;

class NotFoundContainerException extends Exception implements INotFoundException
{
  protected $message = 'The given class could not be found in container';
  protected $code = 404;
}