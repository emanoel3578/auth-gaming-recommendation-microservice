<?php

namespace App\Container;
use App\Container\Interfaces\IContainer;
use App\Exceptions\NotFoundContainerException;
use ReflectionClass;

class Container implements IContainer
{
  protected array $instances = [];

  public function get($id): mixed
  {
    if ($this->has($id)) {
      return $this->instances[$id];
    }

    $instance = $this->createObject($id);

    $this->instances[$id] = $instance;

    return $instance;
  }

  public function has($id): bool
  {
   return isset($this->instances[$id]);
  }

  private function createObject(string $className): mixed
  {
    if (!class_exists($className)) {
      throw new NotFoundContainerException;
    }

    $reflectionClass = new ReflectionClass($className);
    $reflectionClassConstructor = $reflectionClass->getConstructor();

    if ($reflectionClassConstructor == null) {
      return new $className;
    }

    $parameters = $reflectionClassConstructor->getParameters();

    $dependencies = $this->buildDependencies($parameters);

    return $reflectionClass->newInstanceArgs($dependencies);
  }

  private function buildDependencies(array $parameters): array
  {
    $dependencies = [];

    foreach ($parameters as $parameter) {
      $dependencies[] = $this->createObject($parameter->getClass()->getName());
    }

    return $dependencies;
  }
}