<?php

namespace Vortrixs\Portfolio\Public\Components\CVList;

class ViewModel
{
    public function __construct(private Model $model)
    {
    }

    /**
     * return Generator<array{position: string, company: string, length: string, tags: string, description: string}>
     */
    public function getCvList(): \Generator
    {
        foreach ($this->model->list() as $item) {
            yield $item->toArray();
        }
    }
}
