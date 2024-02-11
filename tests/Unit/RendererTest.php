<?php


namespace Tests\Unit;

use Tests\Support\UnitTester;
use Vortrixs\Portfolio\Renderer;
use Vortrixs\Portfolio\TemplateFinder;

class RendererTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected TemplateFinder $templateFinder;

    protected function _before()
    {
        $this->templateFinder = new TemplateFinder(getcwd() . '/tests/Support/Data/templates');
    }

    public function testCanRenderViewTemplate(): void {
        $view = new class {
            public function getHelloWorld(): string { return 'Hello World'; }
        };
        $renderer = new Renderer($this->templateFinder);

        $expected = <<<HTML
        <html>
            <head>
            </head>
            <body>
                <main>{$view->getHelloWorld()}</main>
            </body>
        </html>
        HTML;

        $output = $renderer->renderView($view, 'view.template');

        $this->tester->assertSame($expected, $output);
    }

    public function testCanRenderLayoutTemplate(): void {
        $content = 'This is my custom content';
        $renderer = new Renderer($this->templateFinder);

        $expected = <<<HTML
        <html>
            <head>
            </head>
            <body>
                <main>{$content}</main>
            </body>
        </html>
        HTML;

        $output = $renderer->renderLayout($content, 'layout.template');

        $this->tester->assertSame($expected, $output);
    }

    public function testCanRenderViewInLayout() {
        $view = new class {
            public function getHelloWorld(): string { return 'Hello World'; }
        };
        $renderer = new Renderer($this->templateFinder);

        $expected = <<<HTML
        <html>
            <head>
            </head>
            <body>
                <main><p>{$view->getHelloWorld()}</p></main>
            </body>
        </html>
        HTML;

        $output = $renderer->render($view, 'view2.template', 'layout.template');

        $this->tester->assertSame($expected, $output);
    }

    // test can pass custom <head> tags
}
