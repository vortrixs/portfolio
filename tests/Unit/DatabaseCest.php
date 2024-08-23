<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;
use Vortrixs\Portfolio\SharedKernel\Database;

class DatabaseCest
{
    public function canReadAndWrite(UnitTester $I)
    {
        $db = new Database($I->getDatabaseFile());

        $userData = [
            'username' => 'my-username',
            'email' => 'my-email@localhost',
            'password' => md5('p455w0rd'),
        ];

        $db->write(data: $userData, table: 'users');

        $response = $db->read(columns: '*', table: 'users', limit: 1);

        $I->assertEquals($userData, $response);
    }

    // can update

    // can delete
}
