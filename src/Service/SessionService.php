<?php

namespace Akbarprayuda\PhpMvc\Service;

use Akbarprayuda\PhpMvc\Domain\Session;
use Akbarprayuda\PhpMvc\Domain\User;
use Akbarprayuda\PhpMvc\Repository\SessionRepository;
use Akbarprayuda\PhpMvc\Repository\UserRepository;

class SessionService
{
    public static string $COOKIE_NAME = "X-PZN-SESSION";

    private SessionRepository $sessionRepository;

    private UserRepository $userRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public function create(string $user_id): Session
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUser_id($user_id);

        $this->sessionRepository->save($session);

        setcookie(self::$COOKIE_NAME, $session->getId(), time() + (60 * 60 * 24 * 30), "/");

        return $session;
    }

    public function destroy()
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';

        $this->sessionRepository->deleteById($sessionId);

        setcookie(self::$COOKIE_NAME, '', 1, "/");
    }

    public function current(): ?User
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';

        $session = $this->sessionRepository->getById($sessionId);

        if ($session === null) {
            return null;
        }

        return $this->userRepository->getById($session->getUser_id());
    }
}
