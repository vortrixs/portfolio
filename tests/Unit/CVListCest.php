<?php

use Tests\Support\UnitTester;
use Vortrixs\Portfolio\Public\Components\CVList\{Entity, Model, ViewModel};

class CVListCest
{
    public function _before(UnitTester $I)
    {
        $I->prepareDatabase();
        $I->createCVTable();
    }

    public function canCreateList(UnitTester $I)
    {
        /** @var Model $model */
        $model = $I->get(Model::class);

        $entities = [
            new Entity(1, 'Junior Backend Developer', 'Company #1', 'Full-time', '2010 - 2011', ['PHP', 'MySQL'], 'This was my first job'),
            new Entity(2, 'Fullstack Developer', 'Company #2', 'Contract', '2012 - 2014', ['PHP', 'Postgres', 'TypeScript', 'Svelte'], 'This was an awesome job')
        ];
        array_walk($entities, $model->create(...));

        $viewModel = new ViewModel($model);

        $I->assertCount(2, iterator_to_array($viewModel->getCvList()));
    }

    public function canUpdateList(UnitTester $I)
    {
        /** @var Model $model */
        $model = $I->get(Model::class);

        $entities = [
            new Entity(1, 'Junior Backend Developer', 'Company #1', 'Full-time', '2010 - 2011', ['PHP', 'MySQL'], 'This was my first job'),
            new Entity(2, 'Fullstack Developer', 'Company #2', 'Contract', '2012 - 2014', ['PHP', 'Postgres', 'TypeScript', 'Svelte'], 'This was an awesome job')
        ];
        array_map($model->create(...), $entities);

        $model->update(new Entity(1, 'New Position', 'Random Startup Venture', 'Unpaid intern', '2020', ['NextJS'], 'Total scam'));

        $viewModel = new ViewModel($model);

        $list = $viewModel->getCvList();
        $cv_a = $list->current();

        // assert item 1 has been updated
        $I->assertSame('New Position', $cv_a['position']);
        $I->assertSame('Random Startup Venture', $cv_a['company']);
        $I->assertSame('Unpaid intern', $cv_a['employmentType']);
        $I->assertSame('2020', $cv_a['length']);
        $I->assertSame(['NextJS'], $cv_a['tags']);
        $I->assertSame('Total scam', $cv_a['description']);

        $list->next();
        $cv_b = $list->current();

        // assert item 2 is unchanged
        $I->assertSame('Fullstack Developer', $cv_b['position']);
        $I->assertSame('Company #2', $cv_b['company']);
        $I->assertSame('Contract', $cv_b['employmentType']);
        $I->assertSame('2012 - 2014', $cv_b['length']);
        $I->assertSame(['PHP', 'Postgres', 'TypeScript', 'Svelte'], $cv_b['tags']);
        $I->assertSame('This was an awesome job', $cv_b['description']);
    }

    public function canDeleteItemFromList(UnitTester $I)
    {
        /** @var Model $model */
        $model = $I->get(Model::class);

        $entities = [
            new Entity(1, 'Junior Backend Developer', 'Company #1', 'Full-time', '2010 - 2011', ['PHP', 'MySQL'], 'This was my first job'),
            new Entity(2, 'Fullstack Developer', 'Company #2', 'Contract', '2012 - 2014', ['PHP', 'Postgres', 'TypeScript', 'Svelte'], 'This was an awesome job')
        ];
        array_walk($entities, $model->create(...));

        $model->delete($entities[0]->id);

        $viewModel = new ViewModel($model);

        $cvList = $viewModel->getCvList();

        $item = $cvList->current();

        $I->assertCount(1, iterator_to_array($cvList));
        $I->assertSame('Fullstack Developer', $item['position']);
        $I->assertSame('Company #2', $item['company']);
        $I->assertSame('Contract', $item['employmentType']);
        $I->assertSame('2012 - 2014', $item['length']);
        $I->assertSame(['PHP', 'Postgres', 'TypeScript', 'Svelte'], $item['tags']);
        $I->assertSame('This was an awesome job', $item['description']);
    }
}
