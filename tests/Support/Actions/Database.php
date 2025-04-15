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
    public function runInstallSql()
    {
        $sql = file_get_contents(codecept_root_dir('sql/install.sql'));

        $this->get(Core\Database::class)->query($sql);
    }
}