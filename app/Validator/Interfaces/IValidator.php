<?php

namespace App\Validator\Interfaces;

interface IValidator
{
  public function validate(mixed $data): void;
}