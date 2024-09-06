<?php

namespace Tests\Unit;

use Tests\Support\Data\ValidView;
use Tests\Support\Data\InvalidView;
use Tests\Support\Helper\App;
use Tests\Support\UnitTester;
use Vortrixs\Portfolio\SharedKernel\Renderer;

class RendererCest
{
    public function testCanRenderViewBasedOnViewModel(UnitTester $I): void
    {
        /** @var Renderer $renderer */
        $renderer = $I->get(Renderer::class);
        $viewModel = new ValidView\ViewModel;

        $expected = <<<HTML
        <html>
            <head></head>
            <body><main>{$viewModel->getHelloWorld()}</main></body>
        </html>
        HTML;

        $output = $renderer->renderSnippet($viewModel);

        $I->assertSame($expected, $output);
    }

    public function testCannotRenderViewIfOnlyViewModelExists(UnitTester $I): void
    {
        /** @var Renderer $renderer */
        $renderer = $I->get(Renderer::class);
        $viewModel = new InvalidView\ViewModel;

        $I->expectThrowable(
            new \RuntimeException('View not found for view model: ' . $viewModel::class),
            fn() => $renderer->renderSnippet($viewModel),
        );
    }
}
