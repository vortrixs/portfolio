<?php

namespace Vortrixs\Portfolio\Navigation;

use Vortrixs\Portfolio\SharedKernel\UrlHelper;

class ViewModel
{
    public function __construct(private UrlHelper $urlHelper)
    {
    }

    /**
     * @return array<array{url: string, label: string}>
     */
    public function getPages(): array
    {
        return [
            ['url' => $this->urlHelper->home, 'label' => 'Home'],
            ['url' => $this->urlHelper->portfolio, 'label' => 'Portfolio']
        ];
    }
}
