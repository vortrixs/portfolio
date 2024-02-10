<?php

namespace Vortrixs\Portfolio\Public;

use Vortrixs\Portfolio\Provider;

require __DIR__ . '/../vendor/autoload.php';

$container = new \DI\Container();

$app = \DI\Bridge\Slim\Bridge::create($container);

$container->make(Provider::class);

$app->addErrorMiddleware(false, false, false);

$app->run();