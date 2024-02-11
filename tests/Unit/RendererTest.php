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
            <head></head>
            <body><main>{$view->getHelloWorld()}</main></body>
        </html>
        HTML;

        $output = $renderer->render($view, 'view.template');

        $this->tester->assertSame($expected, $output);
    }
}
