<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;

class HomeCest
{
    public function canLoadHomePage(FunctionalTester $I)
    {
        $I->haveHttpHeader('Accept', 'text/html');

        $I->sendGet('/');

        $I->seeResponseCodeIsSuccessful();
        $I->seeHttpHeader('Content-Type', 'text/html');
    }
}
