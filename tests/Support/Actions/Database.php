<?php

namespace Tests\Support\Actions;

use Vortrixs\Portfolio\Core; 

trait Database {
    public function prepareDatabase()
    {
        $this->getApp()->getContainer()->set(Core\Database::class, new Core\Database($this->getDatabaseFile()));
    }

    public function createCVTable()
    {
        $this->get(Core\Database::class)->query(<<<SQL
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