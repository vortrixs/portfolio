<?php

namespace Vortrixs\Portfolio;

class Renderer {
    public function __construct(private TemplateFinder $templateFinder) {
    }

    public function render(object $view, string $templateName) : string {
        $templateClosure = include($this->templateFinder->get($templateName));

        ob_start();

        call_user_func($templateClosure, $view);

        return trim(ob_get_clean());
    }
}