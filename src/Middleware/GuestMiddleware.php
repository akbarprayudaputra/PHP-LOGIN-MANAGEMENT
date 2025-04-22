<?php

namespace Akbarprayuda\PhpMvc\Middleware;

use Akbarprayuda\PhpMvc\Config\Database;
use Akbarprayuda\PhpMvc\Config\Middleware;
use Akbarprayuda\PhpMvc\Config\View;
use Akbarprayuda\PhpMvc\Repository\SessionRepository;
use Akbarprayuda\PhpMvc\Repository\UserRepository;
use Akbarprayuda\PhpMvc\Service\SessionService;

class GuestMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function before(): void
    {
        $user = $this->sessionService->current();

        if ($user !== null) {
            View::redirect("/");
            exit();
        }
    }
}
