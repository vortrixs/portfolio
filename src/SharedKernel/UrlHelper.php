<?php

namespace Vortrixs\Portfolio\SharedKernel;

class UrlHelper
{
    public function __construct(
        public readonly string $home = '/',
        public readonly string $portfolio = '/portfolio',
    ) {
    }
}
