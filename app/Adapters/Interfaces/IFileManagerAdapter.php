<?php

namespace App\Adapters\Interfaces;

interface IFileManagerAdapter
{
  public function findFilesByName(string $fileName, string $path = 'app', string $format = 'php'): array;
  public function findFilesByContents(string $fileName, string $contents, string $path = 'app'): array;
}