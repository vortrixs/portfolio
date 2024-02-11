<?php

namespace Vortrixs\Portfolio;

use Slim\App;

function createApp(): App {
    $container = new \DI\Container();

    $app = \DI\Bridge\Slim\Bridge::create($container);

    $container->make(Provider::class);

    $app->addErrorMiddleware(true, false, false);

    return $app;
};