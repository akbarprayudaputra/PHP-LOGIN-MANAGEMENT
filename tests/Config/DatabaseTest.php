<?php

namespace Akbarprayuda\PhpMvc\Test\Config;

use Akbarprayuda\PhpMvc\Config\Database;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertSame;

class DatabaseTest extends TestCase
{
    public function testGetConnection(): void
    {
        $connection = Database::getConnection();

        self::assertNotNull($connection);
    }

    public function testGetConnectionSingleton(): void
    {
        $connection1 = Database::getConnection();
        $connection2 = Database::getConnection();

        assertSame($connection1, $connection2);
    }
}
