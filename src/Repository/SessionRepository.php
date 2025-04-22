<?php

namespace Akbarprayuda\PhpMvc\Repository;

use Akbarprayuda\PhpMvc\Domain\Session;

class SessionRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }


    public function save(Session $session): Session
    {
        $stmt = $this->connection->prepare("INSERT INTO sessions (id, user_id) VALUES (?, ?)");
        $stmt->execute([$session->getId(), $session->getUser_id()]);
        return $session;
    }

    public function getById(string $id): ?Session
    {
        $stmt = $this->connection->prepare("SELECT id, user_id FROM sessions WHERE id = ?");
        $stmt->execute([$id]);

        try {
            if ($row = $stmt->fetch()) {
                $session = new Session();
                $session->setId($row["id"]);
                $session->setUser_id($row["user_id"]);

                return $session;
            } else {
                return null;
            }
        } finally {
            $stmt->closeCursor();
        }
    }

    public function deleteById(string $id): void
    {
        $stmt = $this->connection->prepare("DELETE FROM sessions WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function delete(): void
    {
        $this->connection->prepare("DELETE FROM sessions");
    }
}
