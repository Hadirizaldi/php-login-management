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

    // function test register

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
      $_POST['name'] = '';
      $_POST['password'] = '';

      $this->userController->postRegister();

      $this->expectOutputRegex("[Register]");
      $this->expectOutputRegex("[Id]");
      $this->expectOutputRegex("[Name]");
      $this->expectOutputRegex("[Password]");
      $this->expectOutputRegex("[Register new User]");
      // $this->expectOutputRegex("[Id, Name, Password can't blank !!]");
      $this->expectOutputRegex("[Id field can't be blank! ]");
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
    // end test register

    // test Login 

    public function testLoginSuccess()
    {
      // create dummy user
      $id = "aldi";
      $name = "Aldi";
      $password = password_hash("aldi", PASSWORD_BCRYPT);
      $user = new User($id, $name, $password);

      $this->userRepository->save($user);

      $_POST['id'] = 'aldi';
      $_POST['password'] = 'aldi';

      $this->userController->postLogin();

      $this->expectOutputRegex("[Location: /]");
    }

    public function testLoginValidationError()
    {
      $_POST['id'] = '';
      $_POST['password'] = '';

      $this->userController->postLogin();

      $this->expectOutputRegex("[Login user]");
      $this->expectOutputRegex("[Id]");
      $this->expectOutputRegex("[Password]");
      $this->expectOutputRegex("[Id field can't be blank! ]");
    }

    public function testLoginUserNotFound()
    {
      $_POST['id'] = 'notfound';
      $_POST['password'] = 'notfound';

      $this->userController->postLogin();

      $this->expectOutputRegex("[Login user]");
      $this->expectOutputRegex("[Id]");
      $this->expectOutputRegex("[Password]");
      $this->expectOutputRegex("[Id or password is wrong]");
    }

    public function testLoginWrongPassword()
    {
      // create dummy user
      $id = "aldi";
      $name = "Aldi";
      $password = password_hash("aldi", PASSWORD_BCRYPT);
      $user = new User($id, $name, $password);

      $this->userRepository->save($user);

      $_POST['id'] = 'aldi';
      $_POST['password'] = 'salah';

      $this->userController->postLogin();

      $this->expectOutputRegex("[Login user]");
      $this->expectOutputRegex("[Id]");
      $this->expectOutputRegex("[Password]");
      $this->expectOutputRegex("[Id or password is wrong]");
    }

    // end test Login
  }
}
