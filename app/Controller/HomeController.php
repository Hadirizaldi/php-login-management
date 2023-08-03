<?php

namespace Hadirizaldi\PhpMvc\Controller;

use Hadirizaldi\PhpMvc\App\View;

class HomeController
{
  function index()
  {
    View::render('Home/index', [
      'title' => 'PHP Login Management'
    ]);
  }
}
