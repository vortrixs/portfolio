<?php

namespace Vortrixs\Portfolio\Core;

use DI\Container;

class ViewModelFactory
{
    public function __construct(private Container $container) {}

    /**
     * @template T of object
     * @param class-string<T> $view FQCN for the view being created
     * @param array<string,mixed> $args Each key MUST match a property name of the view being created
     * @return T
     */
    public function create(string $view, array $args = []): object {
        return $this->container->make($view, $args);
    }
}