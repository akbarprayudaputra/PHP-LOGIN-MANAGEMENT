<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Akbarprayuda\PhpMvc\Config\Database;
use Akbarprayuda\PhpMvc\Config\Router;
use Akbarprayuda\PhpMvc\Controller\HomeController;
use Akbarprayuda\PhpMvc\Controller\UserController;

Database::getConnection("development");


Router::add("GET", "/", HomeController::class, "index");

Router::add("GET", "/users/register", UserController::class, "register");
Router::add("POST", "/users/register", UserController::class, "registerPost");

Router::add("GET", "/users/login", UserController::class, "login");
Router::add("POST", "/users/login", UserController::class, "loginPost");
Router::add("GET", "/users/logout", UserController::class, "logout");

Router::run();
