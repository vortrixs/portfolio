<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Vortrixs\Portfolio\Public\Components\CVList\{Entity, Model, ViewModel};
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
            new Entity(1, 'Junior Backend Developer', 'Company #1', 'Full-time','2010 - 2011', ['PHP', 'MySQL'], 'This was my first job'),
            new Entity(2, 'Fullstack Developer', 'Company #2', 'Contract','2012 - 2014', ['PHP', 'Postgres', 'TypeScript', 'Svelte'], 'This was an awesome job')
        ];
        array_walk($entities, $model->create(...));

        $viewModel = new ViewModel($model);

        $I->amOnPage($urlHelper->frontpage);

        $I->seeResponseCodeIsSuccessful();

        $I->seeElement('main');
        $I->see('CV', 'h1');

        $list = $viewModel->getCvList();

        $I->assertCount(2, $list);

        foreach ($list as $cv) {
            $I->see("{$cv['position']} @ {$cv['company']}", '.card > .card__title');
            $I->see("{$cv['employmentType']} {$cv['length']}", '.card > .card__line');
            $I->see(implode(', ', $cv['tags']), '.card > .card__line');
            $I->see($cv['description'], '.card > .card__text');
        }
    }
}
