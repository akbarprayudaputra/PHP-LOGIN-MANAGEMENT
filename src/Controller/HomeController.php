<?php

namespace Akbarprayuda\PhpMvc\Controller;

use Akbarprayuda\PhpMvc\Config\Database;
use Akbarprayuda\PhpMvc\Config\View;
use Akbarprayuda\PhpMvc\Repository\SessionRepository;
use Akbarprayuda\PhpMvc\Repository\UserRepository;
use Akbarprayuda\PhpMvc\Service\SessionService;

class HomeController
{
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();

        $userRepository = new UserRepository($connection);
        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function index(): void
    {
        $user = $this->sessionService->current();

        if ($user === null) {
            // redirect ke login atau tampilkan halaman umum
            View::render("Home/index", [
                'title' => 'PHP Login Management'
            ]);
        } else {
            View::render("Home/dashboard", [
                'title' => 'Dashboard',
                'user' => [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                ]
            ]);
        }
    }
}
