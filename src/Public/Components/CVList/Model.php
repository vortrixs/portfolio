<?php

namespace Vortrixs\Portfolio\Public\Components\CVList;

use Generator;
use Vortrixs\Portfolio\Core\Database;

class Model
{
    private readonly Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database->table('cv');
    }

    public function create(Entity $entity)
    {
        $this->database->insert($entity->toArray());
    }

    /**
     * @return Generator<Entity>
     */
    public function list(): Generator
    {
        return $this->database->select(classname: Entity::class);
    }

    public function update(Entity $entity)
    {
        $this->database->update($entity->toArray(), 'id = :id');
    }

    public function delete(int $id)
    {
        $this->database->delete('id', $id);
    }
}
