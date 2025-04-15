<?php

namespace Vortrixs\Portfolio\Core\Page;

readonly class ViewModel
{
    public function __construct(
        public string $content,
        public string $header,
        public ?string $head,
    ) {}
}