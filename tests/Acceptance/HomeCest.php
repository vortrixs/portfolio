<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Vortrixs\Portfolio\Public\Components\CVList\{Entity, Model};
use Vortrixs\Portfolio\Core\UrlHelper;

class HomeCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->prepareDatabase();
        $I->createCVTable();
    }

    public function validateStructure(AcceptanceTester $I)
    {
        /** @var UrlHelper $urlHelper */
        $urlHelper = $I->get(UrlHelper::class);
        /** @var Model $model */
        $model = $I->get(Model::class);

        $entities = [
            new Entity(1, 'Junior Backend Developer', 'Company #1', 'Full-time', '2010 - 2011', ['PHP', 'MySQL'], 'This was my first job'),
            new Entity(2, 'Fullstack Developer', 'Company #2', 'Contract', '2012 - 2014', ['PHP', 'Postgres', 'TypeScript', 'Svelte'], 'This was an awesome job')
        ];
        array_walk($entities, $model->create(...));

        $I->amOnPage($urlHelper->frontpage);

        $I->seeResponseCodeIsSuccessful();

        $I->seeElement('main');
        $I->see('CV', 'h1');
        
        $I->see('Junior Backend Developer @ Company #1', '.card > .card__title');
        $I->see('Full-time, 2010 - 2011', '.card > .card__line');
        $I->see('PHP, MySQL', '.card > .card__line');
        $I->see('This was my first job', '.card > .card__text');

        $I->see('Fullstack Developer @ Company #2', '.card > .card__title');
        $I->see('Contract, 2012 - 2014', '.card > .card__line');
        $I->see('PHP, Postgres, TypeScript, Svelte', '.card > .card__line');
        $I->see('This was an awesome job', '.card > .card__text');
    }
}
