<?php

namespace Tests\Support\Helper;

use Psr\Container\ContainerInterface;

use function Vortrixs\Portfolio\createApp;

trait App
{
    protected function container(): ContainerInterface
    {
        static $container;

        if (!isset($container)) {
            $container = createApp()->getContainer();
        }

        return $container;
    }
}
