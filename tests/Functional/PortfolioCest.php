<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;

class PortfolioCest
{
    public function canLoadPortfolioPage(FunctionalTester $I)
    {
        $I->haveHttpHeader('Accept', 'text/html');

        $I->sendGet('/portfolio');

        $I->seeResponseCodeIsSuccessful();
        $I->seeHttpHeader('Content-Type', 'text/html');
    }
}
