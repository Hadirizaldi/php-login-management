<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Hadirizaldi\PhpMvc\App\Router;
use Hadirizaldi\PhpMvc\Controller\HomeController;
use Hadirizaldi\PhpMvc\Controller\ProductController;

// menambahkan router
Router::add('GET', '/', HomeController::class, 'index');
Router::add('GET', '/hello', HomeController::class, 'hello');
Router::add('GET', '/world', HomeController::class, 'world');
Router::add('GET', '/about', HomeController::class, 'about');

Router::add('GET', '/products/([0-9a-zA-Z]*)/categories/([0-9a-zA-Z]*)', ProductController::class, 'categories');
//untuk melihat router yang didaftarkan
// var_dump(Router::getRoutes());

Router::run();
