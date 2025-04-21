<?php

namespace Akbarprayuda\PhpMvc\Controller;

use Akbarprayuda\PhpMvc\Config\Database;
use Akbarprayuda\PhpMvc\Config\View;
use Akbarprayuda\PhpMvc\Model\UserRegisterRequest;
use Akbarprayuda\PhpMvc\Repository\UserRepository;
use Akbarprayuda\PhpMvc\Service\UserService;

class UserController
{
    private UserService $userService;

    public function __construct()
    {
        $repository = new UserRepository(Database::getConnection());
        $this->userService = new UserService($repository);
    }

    public function register()
    {
        View::render("User/register", [
            "title" => "Register new user",
        ]);
    }

    public function registerPost()
    {
        $request = new UserRegisterRequest();
        $request->id = $_POST['id'];
        $request->name = $_POST['name'];
        $request->password = $_POST['password'];

        try {
            $this->userService->register($request);

            View::redirect("/users/login");
        } catch (\Throwable $th) {
            View::render("User/register", [
                "title" => "Register new user",
                "error" => $th->getMessage(),
            ]);
        }
    }
}
