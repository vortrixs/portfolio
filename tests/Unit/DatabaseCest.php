<?php

namespace Tests\Unit;

use Tests\Support\Helper\App;
use Tests\Support\Helper\IO;
use Tests\Support\UnitTester;
use Vortrixs\Portfolio\SharedKernel\Database;

class DatabaseCest
{
    use IO;
    use App;

    private string $databaseFilePath = '';

    public function _before()
    {
        $this->databaseFilePath = codecept_output_dir('database.sqlite');
        $this->createFile($this->databaseFilePath);
    }

    public function _after()
    {
        $this->deleteFile($this->databaseFilePath);
    }

    // can read and write
    public function canReadAndWrite(UnitTester $I)
    {
        var_dump($I->getApp());

        // $db = new Database($this->databaseFilePath);

        // $userData = [
        //     'username' => 'my-username',
        //     'email' => 'my-email@localhost',
        //     'password' => md5('p455w0rd'),
        // ];

        // $db->write(data: $userData, table: 'users');

        // $response = $db->read(columns: '*', table: 'users', limit: 1);

        // $I->assertEquals($userData, $response);
    }

    // can update

    // can delete
}
