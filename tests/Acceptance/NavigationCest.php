<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Vortrixs\Portfolio\Core\UrlHelper;

class NavigationCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->prepareDatabase();
        $I->createCVTable();
    }

    public function currentPageHasActiveClass(AcceptanceTester $I)
    {
        /** @var UrlHelper $urlHelper */
        $urlHelper = $I->get(UrlHelper::class);

        $I->amOnPage($urlHelper->frontpage);
        $I->seeResponseCodeIsSuccessful();
        $I->seeElement('a.active', ['href' => $urlHelper->frontpage]);
        $I->seeElement('a', ['href' => $urlHelper->portfolio]);

        $I->click("//a[@href='{$urlHelper->portfolio}']");
        $I->seeResponseCodeIsSuccessful();
        $I->seeElement('a', ['href' => $urlHelper->frontpage]);
        $I->seeElement('a.active', ['href' => $urlHelper->portfolio]);
    }
}
