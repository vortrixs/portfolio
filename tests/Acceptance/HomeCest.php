<?php


namespace Tests\Acceptance;

use Tests\Support\Helper\LocalhostServer;
use Tests\Support\AcceptanceTester;
use Vortrixs\Portfolio\Home\ViewModel;

class HomeCest
{
    use LocalhostServer;

    public function testHomePage(AcceptanceTester $I)
    {
        $view = new ViewModel;

        $I->amOnPage('/');

        $I->seeElement('body');
        $I->seeElement('body > main');
        $I->see('Home!!!', 'main h1');
        $I->see('Content for home goes here!!!', 'main p');
        $I->see("This is a prop used from the view: {$view->getHelloWorld()}", 'main p');
    }
}