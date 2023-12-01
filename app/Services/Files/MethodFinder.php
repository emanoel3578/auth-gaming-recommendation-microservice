<?php

namespace App\Services\Files;

use App\Adapters\Interfaces\IFileManagerAdapter;
use App\Services\Interfaces\IMethodFinder;

class MethodFinder implements IMethodFinder
{
  public function __construct(private IFileManagerAdapter $fileManagerAdapter)
  {}

  public function findMethodInClass(string $className, string $methodName): array
  {
    return $this->fileManagerAdapter->findFilesByContents($className, $methodName);
  }
}