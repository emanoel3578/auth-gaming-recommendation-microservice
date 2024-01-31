<?php

namespace App\Exceptions\Database;

use Exception;

class DatabaseConnectionException extends Exception
{
  protected $message = 'There was a error creating a connection to the database';
  protected $code = 403;
}