<?php

namespace Vortrixs\Portfolio\Public\Components\CVList;

class ViewModel
{
    public function __construct(private Model $model)
    {
    }

    /**
     * return array<{position: string, company: string, length: string, tags: string, description: string}>
     */
    public function getCvList(): array
    {
        return array_map($this->formatCv(...), $this->model->list());
    }

    private function formatCv(Entity $entity)
    {
        return $entity->toArray();
    }
}
