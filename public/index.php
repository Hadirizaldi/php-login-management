<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Hadirizaldi\PhpMvc\App\Router;
use Hadirizaldi\PhpMvc\Config\Database;
use Hadirizaldi\PhpMvc\Controller\HomeController;
use Hadirizaldi\PhpMvc\Controller\UserController;

Database::getConnection("prod");

// menambahkan router
Router::add('GET', '/', HomeController::class, 'index', []);
Router::add('GET', '/users/register', UserController::class, 'register', []);
Router::add('POST', '/users/register', UserController::class, 'postRegister', []);

//untuk melihat router yang didaftarkan
// var_dump(Router::getRoutes());

Router::run();
