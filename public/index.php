<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Hadirizaldi\PhpMvc\App\Router;
use Hadirizaldi\PhpMvc\Controller\HomeController;

// menambahkan router
Router::add('GET', '/', HomeController::class, 'index', []);

//untuk melihat router yang didaftarkan
// var_dump(Router::getRoutes());

Router::run();
