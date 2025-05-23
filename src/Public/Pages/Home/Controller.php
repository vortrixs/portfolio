<?php

namespace Vortrixs\Portfolio\Public\Pages\Home;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamFactoryInterface;
use Vortrixs\Portfolio\Core\ViewModelFactory;
use Vortrixs\Portfolio\Public;
use Vortrixs\Portfolio\Public\Components;

class Controller
{
    public function __construct(
        private Public\Renderer $renderer,
        private ViewModelFactory $viewModelFactory,
        private StreamFactoryInterface $streamFactory,
    ) {}

    public function __invoke(Request $request, Response $response)
    {
        $viewModel = $this->viewModelFactory->create(Components\CVList\ViewModel::class);

        $head = [
            '<meta property="og:title" content="Home">',
            '<meta property="og:url" content="https://he-jepsen.dk/">'
        ];

        $body = $this->streamFactory->createStream(
            $this->renderer->renderPage($viewModel, $head, $request)
        );

        return $response
            ->withBody($body)
            ->withHeader('Content-Type', 'text/html');
    }
}
