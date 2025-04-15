<?php

namespace Tests\Support\Actions;

use Vortrixs\Portfolio\Core; 

trait Database {
    public function prepareDatabase()
    {
        $this->getApp()->getContainer()->set(Core\Database::class, new Core\Database($this->getDatabaseFile()));
    }

    /**
     * @see sql/install.sql
     */
    public function setUpApplicationDatabase()
    {
        $sqlDir = codecept_root_dir('sql');

        exec("{$sqlDir}/install.sh {$sqlDir} {$this->getDatabaseFile()}", $output, $resultCode);

        if (0 !== $resultCode) {
            var_dump($output);
            die;
        }
    }
}