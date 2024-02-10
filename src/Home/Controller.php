<?php

namespace Vortrixs\Portfolio\Home;

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
        $head = <<<HTML
            <meta property="og:title" content="Home">
            <meta property="og:url" content="https://he-jepsen.dk/">
        HTML;
        $body = $this->streamFactory->createStream($this->renderer->render($this->view, $head));

        return $response
            ->withBody($body)
            ->withHeader('Content-Type', 'text/html');
    }
}