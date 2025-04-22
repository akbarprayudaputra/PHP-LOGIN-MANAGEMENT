<?php

namespace Akbarprayuda\PhpMvc\Controller;

use Akbarprayuda\PhpMvc\Config\Database;
use Akbarprayuda\PhpMvc\Config\View;
use Akbarprayuda\PhpMvc\Model\UserLoginRequest;
use Akbarprayuda\PhpMvc\Model\UserRegisterRequest;
use Akbarprayuda\PhpMvc\Repository\SessionRepository;
use Akbarprayuda\PhpMvc\Repository\UserRepository;
use Akbarprayuda\PhpMvc\Service\SessionService;
use Akbarprayuda\PhpMvc\Service\UserService;

class UserController
{
    private UserService $userService;
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $sessionRepository = new SessionRepository($connection);
        $this->userService = new UserService($userRepository);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
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

    public function login()
    {
        View::render("User/login", ["title" => "Login User"]);
    }

    public function loginPost()
    {
        $request = new UserLoginRequest();
        $request->id = $_POST["id"];
        $request->password = $_POST["password"];

        try {
            $response = $this->userService->login($request);
            $this->sessionService->create($response->user->getId());

            View::redirect("/");
        } catch (\Throwable $th) {
            View::render("User/login", [
                "title" => "Login User",
                "error" => $th->getMessage(),
            ]);
        }
    }

    public function logout()
    {
        $this->sessionService->destroy();
        View::redirect("/");
    }
}
