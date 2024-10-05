<?php

namespace Vortrixs\Portfolio\Public; 

use Vortrixs\Portfolio\SharedKernel\Renderer as SharedKernelRenderer;
use Vortrixs\Portfolio\SharedKernel\Page;
use Vortrixs\Portfolio\SharedKernel\ViewModelFactory;

class Renderer {
    public function __construct(private SharedKernelRenderer $renderer, private ViewModelFactory $viewModelFactory)
    {
        
    }

    public function renderPage(object $viewModel, array $head = []): string
    {
        $rendered_view = $this->renderer->render($viewModel);

        $header = $this->renderer->render($this->viewModelFactory->create(Components\Navigation\ViewModel::class));
        $header .= $this->renderer->render($this->viewModelFactory->create(Components\About\ViewModel::class));

        return $this->renderer->render(new Page\ViewModel($rendered_view, $header, implode(PHP_EOL, $head)));
    }
}
