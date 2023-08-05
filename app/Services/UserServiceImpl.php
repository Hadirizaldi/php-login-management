<?php

namespace Hadirizaldi\PhpMvc\Services;

use Hadirizaldi\PhpMvc\Config\Database;
use Hadirizaldi\PhpMvc\Exceptions\ValidationException;
use Hadirizaldi\PhpMvc\Repositories\UserRepository;
use Hadirizaldi\PhpMvc\Models\UserRegisterRequest;
use Hadirizaldi\PhpMvc\Models\UserRegisterResponse;
use Hadirizaldi\PhpMvc\Domain\User;
use Hadirizaldi\PhpMvc\Models\UserLoginRequest;
use Hadirizaldi\PhpMvc\Models\UserLoginResponse;

class UserServiceImpl implements UserService
{

  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function register(UserRegisterRequest $request): UserRegisterResponse
  {
    // Todo: validate dari Model
    $request->validate();

    try {

      Database::beginTransaction();
      $user = $this->userRepository->findById($request->getId());
      if ($user != null) {
        throw new ValidationException("User ID already exist");
      }

      //tangkap request 
      $id = $request->getId();
      $name = $request->getName();
      $password = password_hash($request->getPassword(), PASSWORD_BCRYPT);
      $user = new User($id, $name, $password);

      // save user
      $this->userRepository->save($user);

      // kembalikan response
      $response = new UserRegisterResponse($user);
      Database::commitTransaction();
      return $response;

      // jika gagal, lakukan rollback
    } catch (\Exception $e) {
      Database::rollbackTransaction();
      throw $e;
    }
  }

  public function login(UserLoginRequest $request): UserLoginResponse
  {
    // Todo : validate dari Model
    $request->validate();

    $user = $this->userRepository->findById($request->getId());
    if ($user == null) {
      throw new ValidationException("Id or password is wrong");
    }

    if (password_verify($request->getPassword(), $user->getPassword())) {
      // jika berhasil validation Id dan password
      $response = new UserLoginResponse($user);

      return $response;
    } else {
      throw new ValidationException("Id or password is wrong");
    }
  }

  // private function validateUserRegister(UserRegisterRequest $request): void
  // {
  //   if (
  //     $request->getId() == null || $request->getName() == null || $request->getPassword() == null ||
  //     trim($request->getId()) == null || trim($request->getName()) == null || trim($request->getPassword()) == null
  //   ) {
  //     throw new ValidationException("Id, Name, Password can't blank !!");
  //   }
  // }

  // private function validateUserLogin(UserLoginRequest $request): void
  // {
  //   if (
  //     $request->getId() == null || $request->getPassword() == null ||
  //     trim($request->getId()) == null || trim($request->getPassword()) == null
  //   ) {
  //     throw new ValidationException("Id, Password can't blank !!");
  //   }
  // }
}
