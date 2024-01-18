<?php

namespace Vortrixs\Portfolio;

use Slim\App as Router;
use DI\Container;
use Vortrixs\Portfolio\Home\Controller as HomeController;
use Vortrixs\Portfolio\CV\Controller as CVController;
use Vortrixs\Portfolio\Code\Controller as CodeController;

class PortfolioProvider {
    public function __construct(private Router $router, private Container $container) {
        $this->registerHome();
        $this->registerCV();
        $this->registerCode();
    }

    public function registerHome() {
        $this->router->get('/', HomeController::class);
    }

    public function registerCV() {
        $this->router->get('/cv', CVController::class);
    }

    private function registerCode() {
        $this->router->get('/code', CodeController::class);
    }
}