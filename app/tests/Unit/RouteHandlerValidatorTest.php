<?php

use App\Exceptions\GivenHandlerClassDoesntExistException;
use App\Factories\RouteHandlerValidatorFactory;
use App\Validator\Interfaces\IRouterHandlerValidator;
use PHPUnit\Framework\TestCase;

class RouteHandlerValidatorTest extends TestCase
{
  private IRouterHandlerValidator $sut;

  protected function setUp(): void
  {
    parent::setUp();
    $this->sut = RouteHandlerValidatorFactory::make();
  }

  public function test_should_validator_throw_exception_if_class_not_found_in_controllers_namespace()
  {
    $className = 'classNonExisting';

    $this->expectException(GivenHandlerClassDoesntExistException::class);

    $this->sut->validate($className);
  }

  public function test_should_validate_true_when_handler_class_exists_in_controllers_namespace()
  {
    $className = 'ExistingDynamicallyClass';

    $filePath = $this->createNamedClassDynamically($className);

    $result = $this->sut->validate($className);

    $this->assertTrue($result);

    $this->removeFiles($filePath);
  }

  public function test_should_throw_exception_when_class_is_found_and_method_is_not_found_in_class()
  {
    $className = 'DynamicallyClass';
    $method = 'notFoundMethodName';

    $handler = $className . '@' . $method;

    $filePath = $this->createNamedClassDynamically($className);

    $this->expectException(GivenMethodNotFoundInHandlerClassException::class);

    $this->sut->validate($handler);

    $this->removeFiles($filePath);
  }

  public function test_should_validate_true_when_class_and_method_is_found_in_controllers_namespace()
  {
    // Method name is the same in the createClassDynamicallyWithMethod method,
    // Don't change the method name in either places otherwise the test will fail

    $className = 'NewClassDynamically';
    $method = 'mockedMethod';

    $handler = $className . '@' . $method;

    $filePath = $this->createNamedClassDynamically($className, $method);

    $result = $this->sut->validate($handler);

    $this->assertTrue($result);

    $this->removeFiles($filePath);
  }

  public function test_should_validate_true_when_class_in_nested_controllers_namespace()
  {
    $className = 'DynamicallyClassNested';
    $nestedPath = 'Nested';

    $filePath = $this->createNamedClassDynamically($className, '{}', 'app/Controllers', $nestedPath);

    $result = $this->sut->validate($className);

    $this->assertTrue($result);

    $this->removeFiles($filePath);
  }

  private function createNamedClassDynamically(
    string $className,
    string $method = '',
    string $namespace = 'app/Controllers',
    string $nestedPath = ''
  ): string {
    $defaultPath = realpath($namespace) . '\\' . $className . '.php';
    $filePath = empty($nestedPath) ?  $defaultPath : realpath($namespace) . '\\' . $nestedPath . '\\' . $className . '.php';

    $this->createDirectoryIfNotExisting($filePath);
    $classFile = fopen($filePath, 'w');

    $method = empty($method) ? $method : "public function {$method}() {}";

    $contents = "<?php class {$className} { {$method} }";

    $clearContents = stripslashes($contents);

    fwrite($classFile, $clearContents);
    fclose($classFile);

    return $filePath;
  }

  private function removeFiles(string $filePath)
  {
    
  }

  private function createDirectoryIfNotExisting(string $filePath)
  {
    $dirname = dirname($filePath);

    if (!is_dir($dirname)) {
      mkdir($dirname, 0755, true);
    }
  }
}
