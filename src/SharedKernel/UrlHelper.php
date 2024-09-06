<?php

namespace Vortrixs\Portfolio\SharedKernel;

class UrlHelper
{
    public function __construct(
        public readonly string $frontpage = '/',
        public readonly string $home = '/home',
        public readonly string $portfolio = '/portfolio',
    ) {}
}
