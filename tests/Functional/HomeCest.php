<?php


namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Vortrixs\Portfolio\Home\View;

class HomeCest
{
    public function _before(FunctionalTester $I)
    {
    }


    public function canLoadHomePage(FunctionalTester $I)
    {
        $I->haveHttpHeader('Accept', 'text/html');

        $I->sendGet('/');

        $I->seeResponseCodeIsSuccessful();
        $I->seeHttpHeader('Content-Type', 'text/html');
    }
}
