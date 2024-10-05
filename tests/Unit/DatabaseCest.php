<?php

namespace Tests\Unit;

use Generator;
use Tests\Support\UnitTester;
use Vortrixs\Portfolio\SharedKernel\Database;

class DatabaseCest
{
    private Database $db;

    public function _before(UnitTester $I)
    {
        $this->db = new Database($I->getDatabaseFile());
        $this->db->query(<<<SQL
        create table if not exists users (
            username text,
            email text,
            password text
        )
        SQL);
    }

    public function canReadAndWrite(UnitTester $I)
    {
        $userData = [
            'username' => 'my-username',
            'email' => 'my-email@localhost',
            'password' => md5('p455w0rd'),
        ];

        $usersTable = $this->db->table('users');

        $hasInserted = $usersTable->insert(data: $userData);

        $I->assertTrue($hasInserted);

        $response = $usersTable->select(columns: ['*']);

        $I->assertInstanceOf(Generator::class, $response);
        $I->assertTrue($response->valid());
        $I->assertEquals((object) $userData, $response->current());
    }

    public function canUpdateRecord(UnitTester $I)
    {
        $userData = [
            'username' => 'my-username',
            'email' => 'my-email@localhost',
            'password' => md5('p455w0rd'),
        ];

        $usersTable = $this->db->table('users');

        $usersTable->insert(data: $userData);

        $updatedData = ['email' => 'my-new-email@localhost'];

        $usersTable->update(data: $updatedData, constraint: "email = :emailWhere", additionalPlaceholders: ['emailWhere' => $userData['email']]);

        $response = $usersTable->select(columns: ['email']);

        $I->assertInstanceOf(Generator::class, $response);
        $I->assertTrue($response->valid());
        $I->assertSame($updatedData['email'], $response->current()->email);
    }

    public function canDeleteRecord(UnitTester $I)
    {
        $userData = [
            'username' => 'my-username',
            'email' => 'my-email@localhost',
            'password' => md5('p455w0rd'),
        ];

        $usersTable = $this->db->table('users');

        $usersTable->insert(data: $userData);

        $response_a = $usersTable->delete('username', 'my-username');

        $response_b = $usersTable->select();

        $I->assertTrue($response_a);
        $I->assertFalse($response_b->valid());
    }
}
