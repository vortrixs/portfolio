<?php

namespace Vortrixs\Portfolio;

use Psr\Http\Message\StreamFactoryInterface;
use Slim\App;
use Slim\Psr7\Factory\StreamFactory;
use Vortrixs\Portfolio\SharedKernel\UrlHelper;
use Vortrixs\Portfolio\Home\Controller as HomeController;
use Vortrixs\Portfolio\Portfolio\Controller as PortfolioController;

function createApp(): App
{
    $container = new \DI\Container();

    $app = \DI\Bridge\Slim\Bridge::create($container);

    $container->set(StreamFactoryInterface::class, $container->get(StreamFactory::class));

    $container->call(function (UrlHelper $urlHelper) {
        $this->router->get($urlHelper->home, HomeController::class);
        $this->router->get($urlHelper->portfolio, PortfolioController::class);
    });

    $app->addErrorMiddleware(true, false, false);

    return $app;
};