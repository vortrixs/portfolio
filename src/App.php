<?php

namespace Vortrixs\Portfolio;

use DI\Bridge\Slim\Bridge;
use DI\Container;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\App;
use Slim\Psr7\Factory\StreamFactory;
use Vortrixs\Portfolio\SharedKernel\UrlHelper;
use Vortrixs\Portfolio\Home\Controller as HomeController;
use Vortrixs\Portfolio\Portfolio\Controller as PortfolioController;
use Vortrixs\Portfolio\SharedKernel\Database;

function createApp(?Database $database = null): App
{
    $container = new Container();

    $app = Bridge::create($container);

    $container->set(StreamFactoryInterface::class, $container->get(StreamFactory::class));

    if ($database) {
        $container->set(Database::class, $database);
    }

    $container->call(function (UrlHelper $urlHelper, App $router) {
        $router->get($urlHelper->home, HomeController::class);
        $router->get($urlHelper->portfolio, PortfolioController::class);
    });

    $app->addErrorMiddleware(true, false, false);

    return $app;
};
