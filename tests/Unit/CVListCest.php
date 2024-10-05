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

        $I->assertCount(2, $viewModel->getCvList());
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

        $model->update($entities[0], [
            'position' => 'New Position',
            'company' => 'Random Startup Venture',
            'employmentType' => 'Unpaid intern',
            'length' => '2020',
            'tags' => ['NextJS'],
            'description' => 'Total scam'
        ]);

        $viewModel = new ViewModel($model);

        [$cv_a, $cv_b] = $viewModel->getCvList();

        // assert item 1 has been updated
        $I->assertSame('New Position', $cv_a['position']);
        $I->assertSame('Random Startup Venture', $cv_a['company']);
        $I->assertSame('Unpaid intern', $cv_a['employmentType']);
        $I->assertSame('2020', $cv_a['length']);
        $I->assertSame('NextJS', $cv_a['tags']);
        $I->assertSame('Total scam', $cv_a['description']);

        // assert item 2 is unchanged
        $I->assertSame('Fullstack Developer', $cv_b['position']);
        $I->assertSame('Company #2', $cv_b['company']);
        $I->assertSame('Contract', $cv_b['employmentType']);
        $I->assertSame('2012 - 2014', $cv_b['length']);
        $I->assertSame('PHP, Postgres, TypeScript, Svelte', $cv_b['tags']);
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
        $I->assertCount(1, $cvList);
        $I->assertSame('Fullstack Developer', $cvList[0]['position']);
        $I->assertSame('Company #2', $cvList[0]['company']);
        $I->assertSame('Contract', $cvList[0]['employmentType']);
        $I->assertSame('2012 - 2014', $cvList[0]['length']);
        $I->assertSame('PHP, Postgres, TypeScript, Svelte', $cvList[0]['tags']);
        $I->assertSame('This was an awesome job', $cvList[0]['description']);
    }
}
