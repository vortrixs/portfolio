<?php

namespace Vortrixs\Portfolio\Public\Pages\Portfolio;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamFactoryInterface;
use Vortrixs\Portfolio\Public;
use Vortrixs\Portfolio\Public\Components;
use Vortrixs\Portfolio\Core\ViewModelFactory;

class Controller
{
    public function __construct(
        private Public\Renderer $renderer,
        private ViewModelFactory $viewModelFactory,
        private StreamFactoryInterface $streamFactory,
    ) {}

    public function __invoke(Response $response)
    {
        $viewModel = $this->viewModelFactory->create(Components\Portfolio\ViewModel::class);

        $head = [
            '<meta property="og:title" content="Portfolio">',
            '<meta property="og:url" content="https://he-jepsen.dk/portfolio">',
        ];

        $body = $this->streamFactory->createStream(
            $this->renderer->renderPage($viewModel, $head)
        );

        return $response
            ->withBody($body)
            ->withHeader('Content-Type', 'text/html');
    }
}
