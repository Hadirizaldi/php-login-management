<?php

namespace Hadirizaldi\PhpMvc\Controller;

use Hadirizaldi\PhpMvc\App\View;
use Hadirizaldi\PhpMvc\Config\Database;
use Hadirizaldi\PhpMvc\Exceptions\ValidationException;
use Hadirizaldi\PhpMvc\Models\UserRegisterRequest;
use Hadirizaldi\PhpMvc\Repositories\UserRepositoryImpl;
use Hadirizaldi\PhpMvc\Services\UserServiceImpl;

class UserController
{

  private UserServiceImpl $userService;

  public function __construct()
  {
    $connection = Database::getConnection();
    $userRepository = new UserRepositoryImpl($connection);
    $this->userService = new UserServiceImpl($userRepository);
  }

  // menampilkan halaman dari register
  public function register()
  {
    View::render(
      'User/Register',
      ['title' => 'Register new user']
    );
  }

  // melakukan aksi dari register
  public function postRegister()
  {
    // tangkap form data 
    $fromData = [
      'id' => $_POST['id'],
      'name' => $_POST['name'],
      'password' => $_POST['password']
    ];

    $request = new UserRegisterRequest(
      $fromData['id'],
      $fromData['name'],
      $fromData['password']
    );
    try {
      // jika berhasil
      $this->userService->register($request);
      View::redirect('/users/login');
    } catch (ValidationException $e) {
      // jika gagal tetap dihalaman dan tambahkan variable error
      View::render(
        'User/Register',
        [
          'title' => 'Register new user',
          'error' => $e->getMessage()
        ]
      );
    }
  }
}
