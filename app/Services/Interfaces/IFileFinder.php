<?php

namespace App\Services\Interfaces;

interface IFileFinder
{
  public function findFile(string $className, string $path): array;
}