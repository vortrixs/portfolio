<?php

namespace Vortrixs\Portfolio;

class Renderer {
    public function __construct(private TemplateFinder $templateFinder) {
    }

    public function renderView(object $view, string $templateName) : string {
        return $this->renderTemplate($view, $templateName);
    }

    public function renderLayout(string $content, string $templateName) : string {
        return $this->renderTemplate($content, $templateName);
    }

    public function render(object $view, string $viewTemplateName, string $layoutTemplateName = 'layout'): string {
        $content = $this->renderTemplate($view, $viewTemplateName);

        return $this->renderTemplate($content, $layoutTemplateName);
    }

    private function renderTemplate(mixed $input, string $templateName) {
        $templateClosure = include($this->templateFinder->get($templateName));

        ob_start();

        call_user_func($templateClosure, $input);

        return trim(ob_get_clean());
    }
}