<?php

namespace Vortrixs\Portfolio\Components\Navigation;

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
            ['url' => $this->urlHelper->home, 'label' => 'CV'],
            ['url' => $this->urlHelper->portfolio, 'label' => 'Portfolio']
        ];
    }
}
