<?php


namespace Tests\Acceptance;

use Tests\Support\Helper\LocalhostServer;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\App;
use Vortrixs\Portfolio\Home\Entity;
use Vortrixs\Portfolio\Home\Model;
use Vortrixs\Portfolio\Home\ViewModel;

class HomeCest
{
    use LocalhostServer;
    use App;

    public function testHomePage(AcceptanceTester $I)
    {
        /** @var Model */
        $model = $this->container()->get(Model::class);

        $entities = [
            new Entity('Junior Backend Developer', 'Company #1', 'Full-time', ['PHP', 'MySQL'], 'This was my first job'),
            new Entity('Fullstack Developer', 'Company #2', 'Contract', ['PHP', 'Postgres', 'TypeScript', 'Svelte'], 'This was an awesome job')
        ];
        array_walk($entities, $model->create(...));

        $viewModel = new ViewModel($model);

        $I->amOnPage('/');

        $I->seeResponseCodeIsSuccessful();

        $I->seeElement('main');
        $I->see('CV', 'h1');

        foreach ($viewModel->getCvList() as $cv) {
            $I->see("{$cv['position']} @ {$cv['company']}", '.card > .card__title');
            $I->see($cv['length'], '.card > .card__line');
            $I->see($cv['tags'], '.card > .card__line');
            $I->see($cv['description'], '.card > .card__text');
        }
    }
}
