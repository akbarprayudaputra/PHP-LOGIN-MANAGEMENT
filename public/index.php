<?php

use Akbarprayuda\PhpMvc\Config\Router;
use Akbarprayuda\PhpMvc\Controller\HomeController;


require_once __DIR__ . "/../vendor/autoload.php";

Router::add("GET", "/", HomeController::class, "index");

Router::run();
