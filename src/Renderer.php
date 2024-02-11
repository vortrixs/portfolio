<?php

namespace Vortrixs\Portfolio;

class Renderer {
    public function __construct(private TemplateFinder $templateFinder) {
    }

    public function renderView(object $view, string $templateName) : string {
        return $this->renderTemplate($view, $templateName, null);
    }

    public function renderLayout(string $content, string $templateName = 'layout', string $head = null) : string {
        return $this->renderTemplate($content, $templateName, $head);
    }

    private function renderTemplate(mixed $input, string $templateName, ?string $head) {
        $templateClosure = include($this->templateFinder->get($templateName));

        ob_start();

        call_user_func($templateClosure, $input, $head);

        return trim(ob_get_clean());
    }
}