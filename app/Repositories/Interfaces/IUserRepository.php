<?php

namespace App\Repositories\Interfaces;

interface IUserRepository
{
  public function register(string $userEmail, string $userPassword): bool;
}