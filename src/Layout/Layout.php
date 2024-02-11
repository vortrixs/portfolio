<?php

namespace Vortrixs\Portfolio\Layout;

class Layout {
    public function __construct(
        public readonly string $content,
        public readonly string $header,
        public readonly ?string $head,
    ) {}
}