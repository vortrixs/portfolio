<?php

namespace Vortrixs\Portfolio\Home;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamFactoryInterface;
use Vortrixs\Portfolio\SharedKernel\Renderer;
use Vortrixs\Portfolio\SharedKernel\ViewModelFactory;

class Controller
{
    public function __construct(
        private Model $model,
        private Renderer $renderer,
        private ViewModelFactory $viewModelFactory,
        private StreamFactoryInterface $streamFactory,
    ) {
    }

    public function __invoke(Response $response)
    {
        $viewModel = $this->viewModelFactory->create(ViewModel::class);
        $head = [
            '<meta property="og:title" content="Home">',
            '<meta property="og:url" content="https://he-jepsen.dk/">'
        ];

        $body = $this->streamFactory->createStream(
            $this->renderer->renderLayout($viewModel, $head)
        );

        return $response
            ->withBody($body)
            ->withHeader('Content-Type', 'text/html');
    }
}
