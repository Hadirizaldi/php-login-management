<?php

namespace Hadirizaldi\PhpMvc\Controller {

  require_once __DIR__ . '/../Helper/Helper.php';

  use Hadirizaldi\PhpMvc\Config\Database;
  use Hadirizaldi\PhpMvc\Domain\User;
  use Hadirizaldi\PhpMvc\Repositories\UserRepositoryImpl;
  use PHPUnit\Framework\TestCase;

  class UserControllerTest extends TestCase
  {

    private UserController $userController;
    private UserRepositoryImpl $userRepository;

    protected function setUp(): void
    {
      $this->userController = new UserController();
      $this->userRepository = new UserRepositoryImpl(Database::getConnection());
      $this->userRepository->deleteAll();

      putenv("mode=test");
    }

    public function testRegister()
    {
      $this->userController->register();

      $this->expectOutputRegex("[Register]");
      $this->expectOutputRegex("[Name]");
      $this->expectOutputRegex("[Id]");
      $this->expectOutputRegex("[Register]");
      $this->expectOutputRegex("[Register new user]");
    }

    public function testPostRegisterSuccess()
    {
      $_POST['id'] = 'aldi';
      $_POST['name'] = 'Aldi';
      $_POST['password'] = 'aldi';

      $this->userController->postRegister();

      $this->expectOutputRegex("[Location: /users/login]");
    }

    public function testPostRegisterValidationError()
    {
      $_POST['id'] = '';
      $_POST['name'] = 'Aldi';
      $_POST['password'] = '';

      $this->userController->postRegister();

      $this->expectOutputRegex("[Register]");
      $this->expectOutputRegex("[Id]");
      $this->expectOutputRegex("[Name]");
      $this->expectOutputRegex("[Password]");
      $this->expectOutputRegex("[Register new User]");
      $this->expectOutputRegex("[Id, Name, Password can't blank !!]");
    }

    public function testPostRegisterDuplicate()
    {

      // buat dummy user
      $user = new User(
        "aldi",
        "Aldi",
        "aldi"
      );

      $this->userRepository->save($user);

      $_POST['id'] = 'aldi';
      $_POST['name'] = 'Aldi';
      $_POST['password'] = 'aldi';

      $this->userController->postRegister();

      $this->expectOutputRegex("[Register]");
      $this->expectOutputRegex("[Id]");
      $this->expectOutputRegex("[Name]");
      $this->expectOutputRegex("[Password]");
      $this->expectOutputRegex("[Register new User]");
      $this->expectOutputRegex("[User ID already exist]");
    }
  }
}
