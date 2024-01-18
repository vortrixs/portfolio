<?php

namespace Vortrixs\Portfolio\Public;

use Vortrixs\Portfolio\PortfolioProvider;

require __DIR__ . '/../vendor/autoload.php';

$container = new \DI\Container();

$app = \DI\Bridge\Slim\Bridge::create($container);

$container->make(PortfolioProvider::class);

$app->addErrorMiddleware(false, false, false);

$app->run();