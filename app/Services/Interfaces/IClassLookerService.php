<?php

namespace App\Services\Interfaces;

interface IClassLookerService
{
  public function findClassByFileName(string $className, string $path): bool;
  public function findMethodInClassByContents(string $className, string $content): bool;
}