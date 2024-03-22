<?php

namespace Vortrixs\Portfolio\SharedKernel;

use Throwable;
use Vortrixs\Portfolio\Navigation;
use Vortrixs\Portfolio\Layout;

class Renderer
{
    public function __construct(private ViewModelFactory $viewModelFactory)
    {
    }

    public function render(object $viewModel): string
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

    public function renderLayout(object $viewModel, array $head = []): string
    {
        $rendered_view = $this->render($viewModel);
        $header = $this->render($this->viewModelFactory->create(Navigation\ViewModel::class));

        return $this->render(new Layout\ViewModel($rendered_view, $header, implode(PHP_EOL, $head)));
    }
}
