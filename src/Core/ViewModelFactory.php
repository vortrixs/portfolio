<?php

namespace Vortrixs\Portfolio\Core;

use DI\Container;

class ViewModelFactory
{
    public function __construct(private Container $container) {}

    /**
     * @template T of object
     * @param class-string<T> $view
     * @return T
     */
    public function create(string $view, mixed ...$args): object {
        return $this->container->make($view, $args);
    }
}