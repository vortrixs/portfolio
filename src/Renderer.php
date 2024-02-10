<?php

namespace Vortrixs\Portfolio;

class Renderer {
    public function render($view) {
        $fqcn_split = explode('\\', get_class($view));

        $template_name = strtolower($fqcn_split[count($fqcn_split) - 2]);
        
        ob_start();
        
        require_once "../templates/{$template_name}.php";

        return $this->renderLayout(ob_get_clean());
    }

    private function renderLayout(string $content) {
        ob_start();

        require_once '../templates/layout.php';

        return ob_get_clean();
    }
}