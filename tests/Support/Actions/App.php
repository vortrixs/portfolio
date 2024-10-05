<?php

namespace Tests\Support\Actions;

use Psr\Container\ContainerInterface;

trait App
{
    public function container(): ContainerInterface
    {
        return $this->getApp()->getContainer();
    }

    public function get(string $name): mixed
    {
        return $this->container()->get($name);
    }
}