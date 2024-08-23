<?php

namespace Vortrixs\Portfolio\Pages\Home;

class Entity
{
    public function __construct(
        public readonly string $position,
        public readonly string $company,
        public readonly string $length,
        public readonly array $tags,
        public readonly string $description,
    ) {
    }
}