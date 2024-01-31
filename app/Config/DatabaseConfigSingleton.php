<?php

namespace App\Config;

class DatabaseConfigSingleton
{
  private static $instances = [];

  protected function __construct(private string $env) { }

  public static function getInstance(string $env = 'local'): self
  {
    $singleInstance = self::class;
    if (!isset(self::$instances[$singleInstance])) {
      return self::$instances[] = new self($env);
    }

    return self::$instances[$singleInstance];
  }

  public static function destroy(): void
  {
    self::$instances = [];
  }

  public function getConfiguration(): array
  {

    if ($this->env === 'testing') {
      return [
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'gamming-recommendation-tests',
        'username' => 'app',
        'password' => 'app-123'
      ];
    }

    return [
      'host' => '127.0.0.1',
      'port' => '3306',
      'database' => 'gamming-recommendation',
      'username' => 'app',
      'password' => 'app-123'
    ];
  }
}