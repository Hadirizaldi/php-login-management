<?php

namespace Hadirizaldi\PhpMvc\Controller;

use Hadirizaldi\PhpMvc\App\View;

class HomeController
{
  public function index(): void
  {
    $model = [
      "title" => "Belajar PHP login-management",
      "content" => "Selamat Belajar PHP login management"
    ];

    // require __DIR__ . "/../View/Home/index.php";
    View::render('Home/index', $model);
  }

  public function hello(): void
  {
    echo "HomeController.hello()";
  }

  public function world(): void
  {
    echo "HomeController.world()";
  }

  public function about(): void
  {
    echo "Author : 'hadi rizaldi r'";
  }

  function login(): void
  {
    $request = [
      "username" => $_POST['username'],
      "password" => $_POST['password']
    ];

    $user = [];

    $response = [
      "message" => "Login Sukses"
    ];
    // kirimkan response ke view
  }
}
