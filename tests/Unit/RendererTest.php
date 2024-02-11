<?php


namespace Tests\Unit;

use Tests\Support\UnitTester;
use Vortrixs\Portfolio\Renderer;

class RendererTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testCanRenderViewTemplate(): void {
        $view = new class {
            public function getHelloWorld(): string { return 'Hello World'; }
        };
        $template = codecept_data_dir('view.template.php');
        $renderer = new Renderer();

        $expected = <<<HTML
        <html>
            <head>
            </head>
            <body>
                <main>{$view->getHelloWorld()}</main>
            </body>
        </html>
        HTML;

        $output = $renderer->renderView($view, $template);

        $this->tester->assertSame($expected, $output);
    }

    public function testCanRenderLayoutTemplate(): void {
        $content = 'This is my custom content';
        $template = codecept_data_dir('layout.template.php');
        $renderer = new Renderer();

        $expected = <<<HTML
        <html>
            <head>
            </head>
            <body>
                <main>{$content}</main>
            </body>
        </html>
        HTML;

        $output = $renderer->renderLayout($content, $template);

        $this->tester->assertSame($expected, $output);
    }

    public function testCanRenderViewInLayout() {
        $view = new class {
            public function getHelloWorld(): string { return 'Hello World'; }
        };
        $layout_template = codecept_data_dir('layout.template.php');
        $view_template = codecept_data_dir('view2.template.php');
        $renderer = new Renderer();

        $expected = <<<HTML
        <html>
            <head>
            </head>
            <body>
                <main><p>{$view->getHelloWorld()}</p></main>
            </body>
        </html>
        HTML;

        $output = $renderer->render($view, $layout_template, $view_template);

        $this->tester->assertSame($expected, $output);
    }

    // test can pass custom <head> tags
}
