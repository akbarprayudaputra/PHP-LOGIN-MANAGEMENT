<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Akbarprayuda\PhpMvc\Config\Database;
use Akbarprayuda\PhpMvc\Config\Router;
use Akbarprayuda\PhpMvc\Controller\HomeController;
use Akbarprayuda\PhpMvc\Controller\UserController;
use Akbarprayuda\PhpMvc\Middleware\AuthMiddleware;
use Akbarprayuda\PhpMvc\Middleware\GuestMiddleware;

Database::getConnection("development");


Router::add("GET", "/", HomeController::class, "index");

Router::add("GET", "/users/register", UserController::class, "register", [GuestMiddleware::class]);
Router::add("POST", "/users/register", UserController::class, "registerPost", [GuestMiddleware::class]);

Router::add("GET", "/users/login", UserController::class, "login", [GuestMiddleware::class]);
Router::add("POST", "/users/login", UserController::class, "loginPost", [GuestMiddleware::class]);
Router::add("GET", "/users/logout", UserController::class, "logout", [AuthMiddleware::class]);

Router::run();
