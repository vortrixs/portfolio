<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Vortrixs\Portfolio\SharedKernel\UrlHelper;

class HomeCest
{
    public function _before(FunctionalTester $I)
    {
        $I->prepareDatabase();
        $I->createCVTable();
    }

    public function canLoadFrontPage(FunctionalTester $I)
    {
        $I->haveHttpHeader('Accept', 'text/html');

        $I->sendGet($I->get(UrlHelper::class)->frontpage);

        $I->seeResponseCodeIsSuccessful();
        $I->seeHttpHeader('Content-Type', 'text/html');
    }


    public function canLoadHomePage(FunctionalTester $I)
    {
        $I->haveHttpHeader('Accept', 'text/html');

        $I->sendGet($I->get(UrlHelper::class)->home);

        $I->seeResponseCodeIsSuccessful();
        $I->seeHttpHeader('Content-Type', 'text/html');
    }
}
