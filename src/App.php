<?php

namespace Vortrixs\Portfolio;

return function () {
    require __DIR__ . '/../vendor/autoload.php';

    $container = new \DI\Container();

    $app = \DI\Bridge\Slim\Bridge::create($container);

    $container->make(Provider::class);

    $app->addErrorMiddleware(true, false, false);

    return $app;
};