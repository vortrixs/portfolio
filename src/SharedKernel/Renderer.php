<?php

namespace Vortrixs\Portfolio\SharedKernel;

use Vortrixs\Portfolio\Layout;

class Renderer
{
    public function __construct(private ViewModelFactory $viewModelFactory)
    {
    }

    public function renderSnippet(object $viewModel): string
    {
        $viewPath = (new \ReflectionClass($viewModel::class))->getFileName();

        $view = @include(dirname($viewPath) . '/View.php');

        if (!$view) {
            throw new \RuntimeException('View not found for view model: ' . $viewModel::class);
        }

        ob_start();

        call_user_func($view, $viewModel);

        return trim(ob_get_clean());
    }

    public function renderPage(object $viewModel, array $head = []): string
    {
        $rendered_view = $this->renderSnippet($viewModel);

        $header = $this->renderSnippet($this->viewModelFactory->create(Layout\Navigation\ViewModel::class));
        $header .= $this->renderSnippet($this->viewModelFactory->create(Layout\About\ViewModel::class));

        return $this->renderSnippet(new Layout\Page\ViewModel($rendered_view, $header, implode(PHP_EOL, $head)));
    }
}
