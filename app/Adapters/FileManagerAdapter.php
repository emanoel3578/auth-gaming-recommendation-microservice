<?php

namespace App\Adapters;

use App\Adapters\Interfaces\IFileManagerAdapter;
use Symfony\Component\Finder\Finder;

class FileManagerAdapter implements IFileManagerAdapter
{
  public function __construct(private Finder $fileFinder)
  {}

  public function findFilesByName(string $fileName, string $path = 'app', string $format = 'php'): array
  {
    $files = $this->fileFinder->create()->files()->in(realpath($path))->name($fileName . '.' . $format);
    return $this->aggregateFiles($files);
  }

  public function findFilesByContents(string $fileName, string $contents, string $path = 'app'): array
  {
    $files = $this->fileFinder->create()->files()->in(realpath($path))->contains($contents);
    return $this->aggregateFiles($files);
  }

  private function aggregateFiles(Finder $files): array
  {
    $filenames = [];
    foreach ($files as $finderFile) {
      $filenames[] = $finderFile->getRealpath();
    }
    return $filenames;
  }
}