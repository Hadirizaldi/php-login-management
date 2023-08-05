<?php

namespace Hadirizaldi\PhpMvc\Services;

use Hadirizaldi\PhpMvc\Config\Database;
use Hadirizaldi\PhpMvc\Exceptions\ValidationException;
use Hadirizaldi\PhpMvc\Repositories\UserRepository;
use Hadirizaldi\PhpMvc\Models\UserRegisterRequest;
use Hadirizaldi\PhpMvc\Models\UserRegisterResponse;
use Hadirizaldi\PhpMvc\Domain\User;

class UserServiceImpl implements UserService
{

  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  private function validateUserRegister(UserRegisterRequest $request): void
  {
    if (
      $request->getId() == null || $request->getName() == null || $request->getPassword() == null ||
      trim($request->getId()) == null || trim($request->getName()) == null || trim($request->getPassword()) == null
    ) {
      throw new ValidationException("Id, Name, Password can't blank !!");
    }
  }

  public function register(UserRegisterRequest $request): UserRegisterResponse
  {
    // Todo: validate
    $this->validateUserRegister($request);
    $user = $this->userRepository->findById($request->getId());

    try {

      Database::beginTransaction();

      if ($user != null) {
        throw new ValidationException("User ID already exist");
      }

      //tangkap request 
      $id = $request->getId();
      $name = $request->getName();
      $password = password_hash($request->getPassword(), PASSWORD_BCRYPT);
      $user = new User($id, $name, $password);

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
}
