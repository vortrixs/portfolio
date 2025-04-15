<?php

namespace Vortrixs\Portfolio\Public\Components\Navigation;

use Psr\Http\Message\ServerRequestInterface;
use Vortrixs\Portfolio\Core\UrlHelper;

class ViewModel
{
    public function __construct(
        private UrlHelper $urlHelper,
        private ServerRequestInterface $request,
    ) {}

    /**
     * @return array<array{url: string, label: string, active: bool}>
     */
    public function getPages(): array
    {
        return [
            ['url' => $this->urlHelper->frontpage, 'label' => 'CV', 'active' => str_ends_with($this->request->getUri(), $this->urlHelper->frontpage)],
            ['url' => $this->urlHelper->portfolio, 'label' => 'Portfolio', 'active' => str_ends_with($this->request->getUri(), $this->urlHelper->portfolio)]
        ];
    }
}
