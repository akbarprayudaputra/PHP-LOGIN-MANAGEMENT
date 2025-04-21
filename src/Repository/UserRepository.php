<?php

namespace Akbarprayuda\PhpMvc\Repository;

use Akbarprayuda\PhpMvc\Domain\User;

class UserRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user): User
    {
        $stmt = $this->connection->prepare("INSERT INTO users (id, name, password) VALUES (?, ?, ?)");
        $stmt->execute([
            $user->getId(),
            $user->getName(),
            $user->getPassword(),
        ]);

        return $user;
    }

    public function getById(string $id): ?User
    {
        $stmt = $this->connection->prepare("SELECT id, name, password FROM users WHERE id = ?");
        $stmt->execute([$id]);

        try {
            if ($row = $stmt->fetch()) {
                $user = new User();
                $user->setId($row["id"]);
                $user->setName($row["name"]);
                $user->setPassword($row["password"]);

                return $user;
            } else {
                return null;
            }
        } finally {
            $stmt->closeCursor();
        }
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE FROM users");
    }
}
