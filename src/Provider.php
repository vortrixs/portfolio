<?php

namespace Vortrixs\Portfolio;

use Slim\App as Router;
use DI\Container;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Factory\StreamFactory;
use Vortrixs\Portfolio\Home\Controller as HomeController;
use Vortrixs\Portfolio\Portfolio\Controller as PortfolioController;

class Provider {
    public function __construct(private Router $router, private Container $container) {
        $this->registerHome();
        $this->registerPortfolio();

        $container->set(StreamFactoryInterface::class, $container->get(StreamFactory::class));
    }

    public function registerHome() {
        $this->router->get('/', HomeController::class);
    }

    private function registerPortfolio() {
        $this->router->get('/portfolio', PortfolioController::class);
    }
}