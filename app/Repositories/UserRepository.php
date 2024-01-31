<?php

namespace App\Repositories;

use App\Database\DatabaseConnectorSingleton;
use App\Repositories\Interfaces\IUserRepository;

class UserRepository implements IUserRepository
{
  public function __construct(protected DatabaseConnectorSingleton $databaseConnection) {}

  public function register(string $userEmail, string $userPassword): bool
  {
    $sqlInsert = "INSERT INTO users(email,password) VALUES(:email,:password)";
    $statement = $this->databaseConnection->getConnection()->prepare($sqlInsert);
    return $statement->execute([':email' => $userEmail, ':password' => $userPassword]);
  }
}
