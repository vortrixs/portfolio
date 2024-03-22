<?php

namespace Vortrixs\Portfolio\Home;

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
        return array_map([$this, 'formatCV'], $this->model->list());
    }

    private function formatCv(Entity $entity)
    {
        return get_object_vars($entity);
    }
}
