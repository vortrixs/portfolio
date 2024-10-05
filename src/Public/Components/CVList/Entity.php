<?php

namespace Vortrixs\Portfolio\Public\Components\CVList;

class Entity
{
    public function __construct(
        public readonly int $id,
        public readonly string $position,
        public readonly string $company,
        public readonly string $employmentType,
        public readonly string $length,
        public readonly array $tags,
        public readonly string $description,
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}