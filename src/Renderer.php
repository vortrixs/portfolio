<?php

class Renderer {
    public function render($view) {
        ob_start();

        $content = $view;

        require_once '../templates/layout.php';

        ob_flush();
    }
}