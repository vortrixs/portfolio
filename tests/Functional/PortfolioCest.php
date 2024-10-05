<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Vortrixs\Portfolio\SharedKernel\UrlHelper;

class PortfolioCest
{
    public function canLoadPortfolioPage(FunctionalTester $I)
    {
        $I->haveHttpHeader('Accept', 'text/html');

        $I->sendGet($I->get(UrlHelper::class)->portfolio);

        $I->seeResponseCodeIsSuccessful();
        $I->seeHttpHeader('Content-Type', 'text/html');
    }
}
