<?php

namespace Vortrixs\Portfolio;

class Renderer {
    public function renderView(object $view, string $templatePath) : string {
        return $this->renderTemplate($view, $templatePath);
    }

    public function renderLayout(string $content, string $templatePath) : string {
        return $this->renderTemplate($content, $templatePath);
    }

    public function render(object $view, string $layoutTemplatePath, string $viewTemplatePath): string {
        $content = $this->renderTemplate($view, $viewTemplatePath);

        return $this->renderTemplate($content, $layoutTemplatePath);
    }

    private function renderTemplate(mixed $input, string $templatePath) {
        $templateClosure = include($templatePath);

        ob_start();

        call_user_func($templateClosure, $input);

        return trim(ob_get_clean());
    }
}