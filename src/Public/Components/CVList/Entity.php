<?php

namespace Vortrixs\Portfolio\Public\Components\CVList;

readonly class Entity
{
    public function __construct(
        public int $id,
        public string $position,
        public string $company,
        public string $employmentType,
        public string $length,
        public array $tags,
        public string $description,
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function fromDatabase(array $data): self
    {
        if (is_string($data['tags'])) {
            $data['tags'] = unserialize($data['tags']);
        }

        return new self(...$data);
    }
}