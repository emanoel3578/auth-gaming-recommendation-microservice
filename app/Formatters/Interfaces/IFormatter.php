<?php

namespace App\Formatters\Interfaces;

interface IFormatter
{
  public function format(mixed $data): mixed;
}