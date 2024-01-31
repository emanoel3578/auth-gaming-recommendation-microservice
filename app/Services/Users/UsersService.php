<?php

namespace App\Services\Users;

use App\Repositories\Interfaces\IUserRepository;

class UsersService
{
  public function __construct(protected IUserRepository $userRepository) {}

  public function registerUser(string $email, string $password): bool
  {
    $user = $this->userRepository->register($email, $password);
    return $user;
  }
}