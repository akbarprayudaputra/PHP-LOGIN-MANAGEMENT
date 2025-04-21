<?php

namespace Akbarprayuda\PhpMvc\Tests\Repository;

use Akbarprayuda\PhpMvc\Config\Database;
use Akbarprayuda\PhpMvc\Domain\User;
use Akbarprayuda\PhpMvc\Repository\UserRepository;
use PHPUnit\Framework\TestCase;


class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;

    public function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());

        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess(): void
    {
        $user = new User();
        $user->setId("1");
        $user->setName("Akbar Prayuda");
        $user->setPassword("password");

        $this->userRepository->save($user);

        $result = $this->userRepository->getById($user->getId());

        self::assertEquals($user->getId(), $result->getId());
        self::assertEquals($user->getName(), $result->getName());
        self::assertEquals($user->getPassword(), $result->getPassword());
    }

    public function testGetByIdNotFound(): void
    {
        $user = $this->userRepository->getById("notFoundId");
        $this->assertNull($user);
    }
}
