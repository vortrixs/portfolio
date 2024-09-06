<?php

namespace Tests\Unit;

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
            password text,
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

        $response = $usersTable->select(columns: '*', limit: 1);

        $I->assertEquals($userData, $response);
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

        $usersTable->update(data: $updatedData);

        $actualEmail = $usersTable->select(columns: 'email');

        $I->assertSame($updatedData['email'], $actualEmail);
    }

    // can delete
    public function canDeleteRecord(UnitTester $I)
    {
        $userData = [
            'username' => 'my-username',
            'email' => 'my-email@localhost',
            'password' => md5('p455w0rd'),
        ];

        $usersTable = $this->db->table('users');

        $usersTable->insert(data: $userData, table: 'users');

        $usersTable->delete();

        $usersTable->select();
    }
}
