<?php

namespace Hadirizaldi\PhpMvc\Services;

use Hadirizaldi\PhpMvc\Config\Database;
use Hadirizaldi\PhpMvc\Exceptions\ValidationException;
use Hadirizaldi\PhpMvc\Repositories\UserRepositoryImpl;
use Hadirizaldi\PhpMvc\Services\UserServiceImpl;
use Hadirizaldi\PhpMvc\Models\UserRegisterRequest;
use Hadirizaldi\PhpMvc\Domain\User;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
  private UserServiceImpl $userService;
  private UserRepositoryImpl $userRepository;

  public function setUp(): void
  {
    $this->userRepository = new UserRepositoryImpl(Database::getConnection());
    $this->userService = new UserServiceImpl($this->userRepository);

    $this->userRepository->deleteAll();
  }

  public function testRegisterSuccess()
  {
    $request = new UserRegisterRequest("aldi", "aldi", "111213");
    $response = $this->userService->register($request);

    // compare
    self::assertEquals($request->getId(), $response->getUser()->getId());
    self::assertEquals($request->getName(), $response->getUser()->getName());

    // untuk compare password yang hash
    self::assertTrue(password_verify($request->getPassword(), $response->getUser()->getPassword()));
  }

  public function testRegisterFailed()
  {
    self::expectException(ValidationException::class);

    $request = new UserRegisterRequest("", "", "");
    $this->userService->register($request);
  }

  public function testRegisterDuplicate()
  {
    $user = new User("aldi", "aldi", "111213");

    $this->userRepository->save($user);

    self::expectException(ValidationException::class);
    $request = new UserRegisterRequest("aldi", "aldi", "111213");
    $this->userService->register($request);
  }
}
