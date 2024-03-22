<?php

namespace Vortrixs\Portfolio;

use DI\Container;
use Slim\App as Router;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Factory\StreamFactory;
use Vortrixs\Portfolio\Home\Controller as HomeController;
use Vortrixs\Portfolio\Portfolio\Controller as PortfolioController;
use Vortrixs\Portfolio\SharedKernel\UrlHelper;

class Provider
{
    public function __construct(private Router $router, private Container $container)
    {
        $container->set(StreamFactoryInterface::class, $container->get(StreamFactory::class));

        $container->call(function (UrlHelper $urlHelper) {
            $this->router->get($urlHelper->home, HomeController::class);
            $this->router->get($urlHelper->portfolio, PortfolioController::class);
        });
    }
}