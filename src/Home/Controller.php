<?php

namespace Vortrixs\Portfolio\Home;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamFactoryInterface;
use Vortrixs\Portfolio\Layout\Header;
use Vortrixs\Portfolio\Layout\Layout;
use Vortrixs\Portfolio\Renderer;

class Controller {
    public function __construct(
        private Model $model,
        private View $view,
        private Renderer $renderer,
        private StreamFactoryInterface $streamFactory,
    ) {}

    public function __invoke(Response $response) {
        $view = $this->renderer->render($this->view, 'home');
        $header = $this->renderer->render(new Header, 'header');
        $head = <<<HTML
            <meta property="og:title" content="Home">
            <meta property="og:url" content="https://he-jepsen.dk/">
        HTML;

        $layout = $this->renderer->render(new Layout($view, $header, $head), 'layout');

        $body = $this->streamFactory->createStream($layout);

        return $response
            ->withBody($body)
            ->withHeader('Content-Type', 'text/html');
    }
}