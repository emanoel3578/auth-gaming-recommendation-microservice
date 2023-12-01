<?php

namespace App\Services\Files;

use App\Adapters\Interfaces\IFileManagerAdapter;
use App\Services\Interfaces\IFileFinder;

class FileFinder implements IFileFinder
{
  public function __construct(private IFileManagerAdapter $fileManagerAdapter)
  {}

  public function findFile(string $className, string $path): array
  {
    return $this->fileManagerAdapter->findFilesByName($className, realpath($path));
  }
}