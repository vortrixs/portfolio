<?php

namespace Vortrixs\Portfolio\Portfolio;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamFactoryInterface;
use Vortrixs\Portfolio\Renderer;

class Controller {
    public function __construct(
        private Model $model,
        private View $view,
        private Renderer $renderer,
        private StreamFactoryInterface $streamFactory,
    ) {

    }

    public function __invoke(Response $response) {
        $body = $this->streamFactory->createStream($this->renderer->render($this->view));

        return $response
            ->withBody($body)
            ->withHeader('Content-Type', 'text/html');
    }
}