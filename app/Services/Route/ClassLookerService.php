<?php

namespace App\Services\Route;

use App\Services\Interfaces\IClassLookerService;
use App\Services\Interfaces\IFileFinder;
use App\Services\Interfaces\IMethodFinder;

class ClassLookerService implements IClassLookerService
{
  public function __construct(private IFileFinder $fileFinder, private IMethodFinder $methodFinder)
  {}

  public function findClassByFileName(string $className, string $pathNamespace): bool
  {
    $foundClass = $this->fileFinder->findFile($className, $pathNamespace);
    
    if(empty($foundClass)) {
      return false;
    }

    return true;
  }

  public function findMethodInClassByContents(string $className, string $content): bool
  {
    $foundClass = $this->methodFinder->findMethodInClass($className, $content);

    if(empty($foundClass)) {
      return false;
    }

    return true;
  }
}
