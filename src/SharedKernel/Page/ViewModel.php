<?php

namespace Vortrixs\Portfolio\SharedKernel\Page;

class ViewModel
{
    public function __construct(
        public readonly string $content,
        public readonly string $header,
        public readonly ?string $head,
    ) {}
}