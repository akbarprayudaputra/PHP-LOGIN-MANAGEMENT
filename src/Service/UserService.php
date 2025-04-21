<?php

namespace Akbarprayuda\PhpMvc\Service;

use Akbarprayuda\PhpMvc\Config\Database;
use Akbarprayuda\PhpMvc\Domain\User;
use Akbarprayuda\PhpMvc\Exception\ValidationException;
use Akbarprayuda\PhpMvc\Model\UserRegisterRequest;
use Akbarprayuda\PhpMvc\Model\UserRegisterResponse;
use Akbarprayuda\PhpMvc\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request): UserRegisterResponse
    {
        $this->validateUserRegisterRequest($request);

        try {
            Database::beginTransaction();
            $user = $this->userRepository->getById($request->id);
            if ($user != null) {
                throw new ValidationException("User already exists");
            }

            $user = new User();
            $user->setId($request->id);
            $user->setName($request->name);
            $user->setPassword(password_hash($request->password, PASSWORD_BCRYPT));

            $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $user;

            Database::commitTransaction();
            return $response;
        } catch (\Exception $th) {
            Database::rollbackTransaction();
            throw $th;
        }
    }

    private function validateUserRegisterRequest(UserRegisterRequest $request): void
    {
        if ($request->id === null || $request->name === null || $request->password === null || trim($request->id) == "" || trim($request->name) == "" || trim($request->password) == "") {
            throw new ValidationException("Id, Name, Password cannot be empty");
        }
    }
}
