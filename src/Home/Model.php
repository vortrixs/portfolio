<?php

namespace Vortrixs\Portfolio\Home;

class Model
{
    private array $storage = [];

    // create
    public function create(Entity $entity)
    {
        $this->storage[] = $entity;
    }

    // read
    public function list()
    {
        return $this->storage;
    }

    // update

    // delete
}
