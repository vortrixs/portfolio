<?php

namespace Vortrixs\Portfolio\Public; 

use Vortrixs\Portfolio\Core\Renderer as SharedRenderer;
use Vortrixs\Portfolio\Core\Page;
use Vortrixs\Portfolio\Core\ViewModelFactory;

class Renderer {
    public function __construct(private SharedRenderer $renderer, private ViewModelFactory $viewModelFactory)
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
