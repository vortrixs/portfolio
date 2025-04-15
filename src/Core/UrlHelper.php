<?php

namespace Vortrixs\Portfolio\Core;

class UrlHelper
{
    public function __construct(
        public readonly string $frontpage = '/',
        public readonly string $portfolio = '/portfolio',
    ) {}
}
