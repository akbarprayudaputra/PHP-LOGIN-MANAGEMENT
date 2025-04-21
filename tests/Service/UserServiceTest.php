<?php

namespace Akbarprayuda\PhpMvc\Tests\Service;

use Akbarprayuda\PhpMvc\Config\Database;
use Akbarprayuda\PhpMvc\Domain\User;
use Akbarprayuda\PhpMvc\Exception\ValidationException;
use Akbarprayuda\PhpMvc\Model\UserRegisterRequest;
use Akbarprayuda\PhpMvc\Repository\UserRepository;
use Akbarprayuda\PhpMvc\Service\UserService;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $service;
    private UserRepository $userRepository;

    public function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->service = new UserService($this->userRepository);

        $this->userRepository->deleteAll();
    }

    public function testRegisterSuccess(): void
    {
        $request = new UserRegisterRequest();

        $request->id = "1";
        $request->name = "Akbar";
        $request->password = "Rahasia";

        $response = $this->service->register($request);

        self::assertEquals($request->id, $response->user->getId());
        self::assertEquals($request->name, $response->user->getName());
        self::assertNotEquals($request->password, $response->user->getPassword());

        self::assertTrue(password_verify($request->password, $response->user->getPassword()));
    }

    public function testRegisterFailed(): void
    {
        self::expectException(ValidationException::class);
        $request = new UserRegisterRequest();

        $request->id = "";
        $request->name = "";
        $request->password = "";

        $this->service->register($request);
    }

    public function testRegisterDuplicated(): void
    {
        $user = new User();

        $user->setId("1");
        $user->setName("akbar");
        $user->setPassword("password");

        $this->userRepository->save($user);

        self::expectException(ValidationException::class);

        $request = new UserRegisterRequest();

        $request->id = "1";
        $request->name = "akbar";
        $request->password = "password";

        $this->service->register($request);
    }
}
