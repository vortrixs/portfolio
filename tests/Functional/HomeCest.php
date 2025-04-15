<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Vortrixs\Portfolio\Core\UrlHelper;

class HomeCest
{
    public function _before(FunctionalTester $I)
    {
        $I->prepareDatabase();
        $I->setUpApplicationDatabase();
    }

    public function canLoadFrontPage(FunctionalTester $I)
    {
        $I->haveHttpHeader('Accept', 'text/html');

        $I->sendGet($I->get(UrlHelper::class)->frontpage);

        $I->seeResponseCodeIsSuccessful();
        $I->seeHttpHeader('Content-Type', 'text/html');
    }
}
