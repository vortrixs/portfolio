<?php

namespace Vortrixs\Portfolio\SharedKernel;

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
}
