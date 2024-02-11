<?php


namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Vortrixs\Portfolio\Portfolio\View;

class PortfolioCest
{
    public function _before(FunctionalTester $I)
    {
    }


    public function canLoadPortfolioPage(FunctionalTester $I)
    {
        $I->haveHttpHeader('Accept', 'text/html');

        $I->sendGet('/portfolio');

        $I->seeResponseCodeIsSuccessful();
        $I->seeHttpHeader('Content-Type', 'text/html');
    }
}
