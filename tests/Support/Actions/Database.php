<?php

namespace Tests\Support\Actions;

use Vortrixs\Portfolio\SharedKernel; 

trait Database {
    public function prepareDatabase()
    {
        $this->getApp()->getContainer()->set(SharedKernel\Database::class, new SharedKernel\Database($this->getDatabaseFile()));
    }

    public function createCVTable()
    {
        $this->get(SharedKernel\Database::class)->query(<<<SQL
        create table if not exists cv (
            id serial primary key,
            position text,
            company text,
            employmentType text,
            length text,
            tags text[],
            description text
        )
        SQL);
    }
}