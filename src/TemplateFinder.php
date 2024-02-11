<?php

namespace Vortrixs\Portfolio;

class TemplateFinder {
    public function __construct(private readonly string $template_root) {
    }

    public function get(string $name): string {
        return "{$this->template_root}/{$name}.php";
    }
}