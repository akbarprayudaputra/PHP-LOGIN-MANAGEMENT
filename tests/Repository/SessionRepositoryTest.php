<?php

namespace Akbarprayuda\PhpMvc\Tests\Repository;

use Akbarprayuda\PhpMvc\Config\Database;
use Akbarprayuda\PhpMvc\Domain\Session;
use Akbarprayuda\PhpMvc\Repository\SessionRepository;
use PHPUnit\Framework\TestCase;


class SessionRepositoryTest extends TestCase
{
    private SessionRepository $repository;

    public function setUp(): void
    {
        $this->repository = new SessionRepository(Database::getConnection());

        $this->repository->delete();
    }

    public function testSave()
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUser_id("akbar");

        $this->repository->save($session);

        $result = $this->repository->getById($session->getId());

        self::assertEquals($session->getId(), $result->getId());

        self::assertEquals($session->getUser_id(), $result->getUser_id());
    }

    public function testDeleteById()
    {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUser_id("akbar");

        $this->repository->save($session);

        $result = $this->repository->getById($session->getId());

        self::assertEquals($session->getId(), $result->getId());

        self::assertEquals($session->getUser_id(), $result->getUser_id());

        $this->repository->deleteById($session->getId());

        $result = $this->repository->getById($session->getId());

        self::assertNull($result);
    }

    public function testSessionNotFound()
    {
        $session = $this->repository->getById("notFoundId");
        self::assertNull($session);
    }
}
